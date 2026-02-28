<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
