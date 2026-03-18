<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    private $backupPath = 'backups';

    public function __construct()
    {
        // Ensure backups directory exists
        if (!Storage::exists($this->backupPath)) {
            Storage::makeDirectory($this->backupPath);
        }
    }

    /**
     * Get list of all backups
     */
    public function list()
    {
        try {
            $backupDir = storage_path('app/' . $this->backupPath);

            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $backups = [];
            $files = scandir($backupDir, SCANDIR_SORT_DESCENDING);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && strpos($file, 'backup_') === 0) {
                    $filepath = $backupDir . '/' . $file;
                    $backups[] = [
                        'filename' => $file,
                        'size' => filesize($filepath),
                        'created_at' => date('Y-m-d H:i:s', filemtime($filepath))
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'backups' => $backups
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new backup
     */
    public function create()
    {
        try {
            $database = env('DB_DATABASE');
            $user = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');

            // Validate database credentials
            if (!$database || !$user) {
                throw new Exception(__('main.backup_database_credentials_incomplete'));
            }

            $backupDir = storage_path('app/' . $this->backupPath);

            // Ensure directory exists
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0775, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupDir . '/' . $filename;

            // Create temporary error file
            $errorFile = $backupDir . '/error_' . time() . '.log';

            // Try to find mysqldump in common locations
            $mysqldump = 'mysqldump';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows paths to check
                $paths = [
                    'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
                    'C:\\laragon\\bin\\mysql\\mysql80\\bin\\mysqldump.exe',
                    'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                    'C:\\wamp64\\bin\\mysql\\mysql8.0\\bin\\mysqldump.exe',
                ];

                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $mysqldump = $path;
                        break;
                    }
                }
            }

            // Use mysqldump to create backup with all tables and data
            $command = escapeshellarg($mysqldump)
                . " --default-character-set=utf8mb4"
                . " --user=" . escapeshellarg($user)
                . " --password=" . escapeshellarg($password)
                . " --host=" . escapeshellarg($host)
                . " --complete-insert"  // Full INSERT statements for easier restore
                . " --routines"          // Include stored procedures
                . " --triggers"          // Include triggers
                . " --events"            // Include scheduled events
                . " " . escapeshellarg($database)
                . " > " . escapeshellarg($filepath)
                . " 2>" . escapeshellarg($errorFile);

            $output = [];
            $return_var = null;
            exec($command, $output, $return_var);

            // Check for errors
            $stderrContent = '';
            if (file_exists($errorFile)) {
                $stderrContent = file_get_contents($errorFile);
                unlink($errorFile);
            }

            // Log the command for debugging
            Log::info('Backup create command: ' . $command);
            Log::info('Return code: ' . $return_var);
            Log::info('Stdout: ' . implode(" | ", $output));
            if ($stderrContent) {
                Log::info('STDERR: ' . $stderrContent);
            }

            if ($return_var !== 0) {
                // Delete corrupted backup file
                if (file_exists($filepath)) {
                    unlink($filepath);
                }

                $errorMsg = $stderrContent ?: (implode(" | ", $output) ?: __('main.backup_unknown_error_check_mysqldump'));
                Log::error('Backup create error: ' . $errorMsg);
                throw new Exception(__('main.backup_create_error', ['error' => $errorMsg]));
            }

            // Verify backup file was created and is not empty
            if (!file_exists($filepath)) {
                throw new Exception(__('main.backup_file_not_found'));
            }

            if (filesize($filepath) == 0) {
                unlink($filepath);
                throw new Exception(__('main.backup_file_empty_check_credentials'));
            }

            return response()->json([
                'success' => true,
                'message' => __('main.backup_created_successfully'),
                'filename' => $filename
            ]);
        } catch (Exception $e) {
            Log::error('Backup create exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a backup file
     */
    public function download($filename)
    {
        try {
            $backupDir = storage_path('app/' . $this->backupPath);
            $filepath = $backupDir . '/' . $filename;

            if (!file_exists($filepath)) {
                return response()->json(['error' => 'Backup not found'], 404);
            }

            return response()->download($filepath, $filename);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Restore from a backup
     */
    public function restore(Request $request)
    {
        try {
            $filename = $request->input('filename');
            $backupDir = storage_path('app/' . $this->backupPath);
            $filepath = $backupDir . '/' . $filename;

            if (!file_exists($filepath)) {
                return back()->with('error', __('main.backup_file_not_found'));
            }

            $database = env('DB_DATABASE');
            $user = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');

            // Try to find mysql in common locations
            $mysql = 'mysql';
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows paths to check
                $paths = [
                    'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe',
                    'C:\\laragon\\bin\\mysql\\mysql80\\bin\\mysql.exe',
                    'C:\\xampp\\mysql\\bin\\mysql.exe',
                    'C:\\wamp64\\bin\\mysql\\mysql8.0\\bin\\mysql.exe',
                ];

                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $mysql = $path;
                        break;
                    }
                }
            }

            // Restore backup with proper character set
            $errorFile = $backupDir . '/restore_error_' . time() . '.log';
            $command = escapeshellarg($mysql) . " --default-character-set=utf8mb4 --user=" . escapeshellarg($user) . " --password=" . escapeshellarg($password) . " --host=" . escapeshellarg($host) . " " . escapeshellarg($database) . " < " . escapeshellarg($filepath) . " 2>" . escapeshellarg($errorFile);

            $output = [];
            $return_var = null;
            exec($command, $output, $return_var);

            // Check for errors
            $stderrContent = '';
            if (file_exists($errorFile)) {
                $stderrContent = file_get_contents($errorFile);
                unlink($errorFile);
            }

            Log::info('Restore command: ' . $command);
            Log::info('Restore return code: ' . $return_var);
            if ($stderrContent) {
                Log::info('Restore STDERR: ' . $stderrContent);
            }

            if ($return_var !== 0) {
                $errorMsg = $stderrContent ?: __('main.unknown');
                Log::error('Backup restore error: ' . $errorMsg);
                return back()->with('error', __('main.backup_restore_failed', ['error' => $errorMsg]));
            }

            return back()->with('success', __('main.backup_restored_successfully'));
        } catch (Exception $e) {
            Log::error('Backup restore exception: ' . $e->getMessage());
            return back()->with('error', __('main.error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Delete a backup
     */
    public function delete(Request $request)
    {
        try {
            $filename = $request->input('filename');
            $backupDir = storage_path('app/' . $this->backupPath);
            $filepath = $backupDir . '/' . $filename;

            if (!file_exists($filepath)) {
                return response()->json(['error' => __('main.backup_file_not_found')], 404);
            }

            unlink($filepath);

            return redirect()->back()->with('success', __('main.backup_deleted_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('main.backup_delete_failed', ['error' => $e->getMessage()]));
        }
    }
}
