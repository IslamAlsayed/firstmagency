<?php

namespace App\Http\Controllers;

use App\Enum\ArticleEnums;
use App\Enum\AvailableToggleFields;
use App\Enum\DepartmentEnums;
use App\Enum\PestDomainEnums;
use App\Enum\ReviewEnums;
use App\Enum\TicketDepartmentEnums;
use App\Enum\TicketEnums;
use App\Enum\WhyUsEnums;
use App\Mail\TicketRatingMail;
use App\Models\Article;
use App\Models\Client;
use App\Models\Department;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\AblyService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    use AblyService;
    public array $availableOption = [];

    public function __construct()
    {
        $enums = [
            AvailableToggleFields::cases(),
            ArticleEnums::cases(),
            PestDomainEnums::cases(),
            ReviewEnums::cases(),
            TicketEnums::cases(),
            TicketDepartmentEnums::cases(),
            WhyUsEnums::cases(),
            DepartmentEnums::cases(),
        ];

        foreach ($enums as $enum) {
            foreach ($enum as $case) {
                $this->availableOption = array_unique(array_merge($this->availableOption, [$case->value]));
            }
        }
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // User Statistics
        $stats = [
            'total_users' => User::count(),
            'superadmins' => User::where('role', 'superadmin')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'content_managers' => User::where('role', 'content_manager')->count(),
        ];

        // Content Statistics
        $contentStats = [
            'articles' => [
                'total' => Article::count(),
                'published' => Article::where('status', 'published')->count(),
                'draft' => Article::where('status', 'draft')->count(),
                'views' => Article::sum('view_count') ?? 0,
            ],
            'services' => [
                'total' => Service::count(),
                'active' => Service::where('is_active', true)->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::where('is_active', true)->count(),
            ],
        ];

        // Support & Engagement Statistics
        $supportStats = [
            'tickets' => [
                'total' => Ticket::count(),
                'open' => Ticket::where('status', 'open')->count(),
                'in_progress' => Ticket::where('status', 'in_progress')->count(),
                'closed' => Ticket::where('status', 'closed')->count(),
            ],
            'reviews' => [
                'total' => Review::count(),
                'approved' => Review::where('status', 'approved')->count(),
                'pending' => Review::where('status', 'pending')->count(),
                'average_rate' => Review::where('status', 'approved')->avg('rate') ?? 0,
            ],
        ];

        // Business Statistics
        $businessStats = [
            'clients' => [
                'total' => Client::count(),
                'active' => Client::where('is_active', true)->count(),
            ],
        ];

        // Recent Activities
        $recentActivities = [
            'latest_articles' => Article::latest()->take(5)->get(['id', 'slug', 'created_at', 'status']),
            'latest_projects' => Project::latest()->take(5)->get(['id', 'title', 'created_at']),
            'latest_tickets' => Ticket::latest()->take(5)->get(['id', 'subject', 'status', 'created_at']),
            'latest_reviews' => Review::latest()->take(5)->get(['id', 'name', 'rate', 'status', 'created_at']),
        ];

        return view('dashboard.index', compact('stats', 'contentStats', 'supportStats', 'businessStats', 'recentActivities'));
    }

    public function settings()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canManageSettings()) {
            abort(403, 'غير مصرح لك بتغيير الإعدادات');
        }

        return view('dashboard.settings');
    }

    // Toggle field for any model
    public function toggleField($modelClass, $id, $field)
    {
        $modelClass = str_replace('_', '-', $modelClass);
        $modelClass = str_replace('-', ' ', $modelClass);
        $modelClass = str_replace(' ', '', ucwords($modelClass));
        $modelClass = '\\App\\Models\\' . $modelClass;
        $model = $modelClass::find($id);

        if (!$model) {
            return response()->json([
                'success' => false,
                'status' => 'info',
                'message' => __('messages.type_not_found', ['type' => __('main.' . strtolower(class_basename($model)))])
            ], 404);
        }

        $this->authorize('update', $model);

        if (!in_array($field, $this->availableOption)) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Invalid field'
            ], 400);
        }

        $newValue = !$model->{$field};
        $model->{$field} = $newValue;
        $model->save();

        // Generate dynamic status label based on field name
        // Extract field name without 'is_' prefix
        $fieldName = str_replace('is_', '', $field);

        // Try to get translations for this specific field, fallback to generic on/off
        $statusLabel = $newValue
            ? __("main.{$fieldName}_on", [], app()->getLocale(), null)
            : __("main.{$fieldName}_off", [], app()->getLocale(), null);

        // If translation doesn't exist, use readable format
        if ($statusLabel === "main.{$fieldName}_on" || $statusLabel === "main.{$fieldName}_off") {
            $readableName = ucfirst(str_replace('_', ' ', $fieldName));
            $statusLabel = $newValue ? $readableName : "Not {$readableName}";
        }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('messages.type_update_to_status', ['type' => __('main.' . strtolower(class_basename($model))), 'status' => $statusLabel]),
            'value' => (bool) $newValue
        ], 200);
    }

    // Delete record for any model (soft delete)
    public function deleteRecord($models, $modelClass, $id)
    {
        $modelClass = str_replace('_', '-', $modelClass);
        $modelClass = str_replace('-', ' ', $modelClass);
        $modelClass = str_replace(' ', '', ucwords($modelClass));
        if (!Str::contains($modelClass, 'us') && !Str::contains($modelClass, 'Us')) {
            $modelClass = implode(' ', array_map('ucfirst', explode('-', singularLowerCaseName($modelClass, '-'))));
        }
        $modelClass = '\\App\\Models\\' . $modelClass;
        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.' . strtolower(class_basename($modelClass)))]));
        }

        $this->authorize('delete', $model);

        $modelName = strtolower(class_basename($modelClass));

        $delete = $model->delete();

        if ($delete) {
            return redirect()->route("$models.index")->withSuccess(__('messages.type_deleted', ['type' => __('main.' . $modelName)]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.' . $modelName)]));
    }

    // Force destroy (permanent delete) for any model
    public function forceDestroy($modelClass, $id)
    {
        $modelClass = str_replace('_', '-', $modelClass);
        $modelClass = str_replace('-', ' ', $modelClass);
        $modelClass = str_replace(' ', '', ucwords($modelClass));
        if (!Str::contains($modelClass, 'us') && !Str::contains($modelClass, 'Us')) {
            $modelClass = implode(' ', array_map('ucfirst', explode('-', singularLowerCaseName($modelClass, '-'))));
        }
        $modelClass = '\\App\\Models\\' . $modelClass;
        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => __('messages.type_not_found', ['type' => __('main.' . strtolower(class_basename($modelClass)))])
                ], 404);
            }
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.' . strtolower(class_basename($modelClass)))]));
        }

        $this->authorize('forceDelete', $model);

        $modelName = strtolower(class_basename($modelClass));
        $model->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('messages.type_force_deleted', ['type' => __('main.' . $modelName)])
            ], 200);
        }

        return redirect()->back()->withSuccess(__('messages.type_force_deleted', ['type' => __('main.' . $modelName)]));
    }

    // Change status for any model
    public function changeStatus($models, $modelClass, $id, $status)
    {
        $modelClass = str_replace('_', '-', $modelClass);
        $modelClass = str_replace('-', ' ', $modelClass);
        $modelClass = str_replace(' ', '', ucwords($modelClass));
        if (!Str::contains($modelClass, 'us') && !Str::contains($modelClass, 'Us')) {
            $modelClass = implode(' ', array_map('ucfirst', explode('-', singularLowerCaseName($modelClass, '-'))));
        }
        $modelClass = '\\App\\Models\\' . $modelClass;
        $model = $modelClass::find($id);

        if (!$model)
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.' . strtolower(class_basename($modelClass)))]));

        // Check if user can update articles
        $this->authorize('update', $model);

        // Validate status
        if (!in_array($status, $this->availableOption)) {
            return redirect()->back()->withError(__('messages.invalid_status'));
        }

        // Get field name from request, default to 'status'
        $field = request()->input('field', 'status');

        $model->update([
            $field => $status,
            'updated_by' => getActiveUserId(),
        ]);

        // Only publish Ably event for Ticket model
        if (class_basename($modelClass) == 'Ticket') {
            $this->publishTicketStatusUpdate($model, $field, $status);

            if (strtolower($status) == TicketEnums::CLOSED->value) {
                // Generate unique token for rating and save to database
                $token = Str::random(40);
                $model->update(['token' => $token]);

                // Reload model to get the updated token
                $model->refresh();

                // Send automated email to customer asking for feedback
                Mail::to($model->email)->send(new TicketRatingMail($model));
            }
        }

        $statusLabel = __('main.' . $status);
        return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.' . strtolower(class_basename($modelClass)))]) . ' - ' . $statusLabel);
    }

    // Ticket status update Ably event publisher
    private function publishTicketStatusUpdate($ticket, $field, $newStatus)
    {
        $ticketData = [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'field' => $field,
            'new_status' => $newStatus,
        ];

        // Generate appropriate label based on field type
        if ($field === 'department_id') {
            $ticketData['status_label'] = Department::find($newStatus)?->name ?? $newStatus;
        } else {
            $ticketData['status_label'] = __('main.' . $newStatus);
        }

        $this->publishToAbly('ticket-updates', 'ticket-status-updated', $ticketData);
    }
}
