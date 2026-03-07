<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enum\AvailableToggleFields;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
        $modelClass = '\\App\\Models\\' . ucfirst($modelClass);
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

    // Force destroy (permanent delete) for any model
    public function forceDestroy($modelClass, $id)
    {
        $modelClass = str_replace('-', ' ', $modelClass);
        $modelClass = str_replace(' ', '', ucwords($modelClass));
        $modelClass = implode(' ', array_map('ucfirst', explode('-', singularLowerCaseName($modelClass, '-'))));
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
                'message' => __('messages.type_deleted', ['type' => __('main.' . $modelName)])
            ], 200);
        }

        return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.' . $modelName)]));
    }
}
