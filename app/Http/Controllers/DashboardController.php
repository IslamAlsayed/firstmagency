<?php

namespace App\Http\Controllers;

use App\Enum\ArticleEnums;
use App\Enum\AvailableToggleFields;
use App\Enum\PestDomainEnums;
use App\Enum\ReviewEnums;
use App\Enum\TicketDepartmentEnums;
use App\Enum\TicketEnums;
use App\Enum\WhyUsEnums;
use App\Mail\TicketRatingMail;
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

        // إحصائيات
        $stats = [
            'total_users' => User::count(),
            'superadmins' => User::where('role', 'superadmin')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'content_managers' => User::where('role', 'content_manager')->count(),
        ];
        return view('dashboard.index', compact('stats'));
    }

    /**
     * صفحة الإعدادات (Colors, Fonts)
     * متاح للـ Super Admin و Admin فقط
     */
    public function settings()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canManageSettings()) {
            abort(403, 'غير مصرح لك بتغيير الإعدادات');
        }

        return view('dashboard.settings');
    }

    /**
     * صفحة الإعدادات (Colors, Fonts)
     * متاح للـ Super Admin و Admin فقط
     */
    public function settings2()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canManageSettings()) {
            abort(403, 'غير مصرح لك بتغيير الإعدادات');
        }

        return view('dashboard.settings2');
    }

    /**
     * صفحة الأقسام (Sections - Padding)
     * متاح للـ Super Admin و Admin فقط
     */
    public function sections()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canManageSections()) {
            abort(403, 'غير مصرح لك بتعديل الأقسام');
        }

        return view('dashboard.sections');
    }

    /**
     * صفحة المحتوى (Services, Articles, etc)
     * متاح للـ جميع الأدوار
     */
    public function content()
    {
        return view('dashboard.content');
    }

    /**
     * صفحة المستخدمين (Users Management)
     * متاح للـ Super Admin فقط
     */
    // public function users()
    // {
    //     /** @var User $user */
    //     $user = Auth::user();
    //     if (!$user->isSuperAdmin()) {
    //         abort(403, 'غير مصرح لك بإدارة المستخدمين');
    //     }

    //     $users = User::all();
    //     return view('dashboard.users', compact('users'));
    // }

    /**
     * صفحة المراجعات (Revisions)
     * متاح للـ Super Admin و Admin
     */
    public function revisions()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->canViewAllRevisions()) {
            abort(403, 'غير مصرح لك بمشاهدة المراجعات');
        }

        return view('dashboard.revisions');
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

        if (!in_array($field, array_column(AvailableToggleFields::cases(), 'value'))) {
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

        // $delete = $model->delete();
        $delete = true;

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
        // $model->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('messages.type_force_deleted', ['type' => __('main.' . $modelName)])
            ], 200);
        }

        return redirect()->back()->withSuccess(__('messages.type_force_deleted', ['type' => __('main.' . $modelName)]));
    }

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
                $model->update(['token' => Str::random(40)]);

                // Send automated email to customer asking for feedback
                Mail::to($model->email)->send(new TicketRatingMail($model));
            }
        }

        $statusLabel = __('main.' . $status);
        return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.' . strtolower(class_basename($modelClass)))]) . ' - ' . $statusLabel);
    }

    private function publishTicketStatusUpdate($ticket, $field, $newStatus)
    {
        $ticketData = [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'field' => $field,
            'new_status' => $newStatus,
            'status_label' => __('main.' . $newStatus),
        ];

        $this->publishToAbly('ticket-updates', 'ticket-status-updated', $ticketData);
    }
}
