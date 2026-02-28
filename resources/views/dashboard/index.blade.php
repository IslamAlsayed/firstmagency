@extends('dashboard.layout.master')

@section('title', __('dashboard.dashboard'))
@section('page-title', '🏠 ' . __('dashboard.dashboard'))

@section('content')
    <!-- {{ __('dashboard.statistics') }} -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-primary rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">{{ __('dashboard.total_users') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg p-4">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-primary rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">{{ __('dashboard.superadmins') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['superadmins'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg p-4">
                    <i class="fas fa-crown text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-primary rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">{{ __('dashboard.admins') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['admins'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg p-4">
                    <i class="fas fa-user-tie text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-primary rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium">{{ __('dashboard.content_managers') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['content_managers'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg p-4">
                    <i class="fas fa-pen text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- {{ __('dashboard.account_info') }} -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- {{ __('dashboard.account_info') }} -->
        <div class="bg-gray-200 rounded-lg shadow p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b">
                <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                <h5 class="text-lg font-semibold text-gray-800">{{ __('dashboard.account_info') }}</h5>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('dashboard.name') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->name }}</p>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('dashboard.email') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->email }}</p>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('dashboard.role') }}</p>
                    <span
                        class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-3 py-1 text-sm font-medium mt-1">{{ auth()->user()->getRoleNameArabic() }}</span>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('dashboard.join_date') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- الصلاحيات الخاصة بك -->
        <div class="bg-gray-200 rounded-lg shadow p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b">
                <i class="fas fa-lock text-2xl text-green-600"></i>
                <h5 class="text-lg font-semibold text-gray-800">{{ __('dashboard.permissions') }}</h5>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <i class="fas fa-{{ auth()->user()->canAccessDashboard() ? 'check text-green-500' : 'times text-red-500' }} w-5"></i>
                    <span class="text-gray-700">{{ __('dashboard.access_dashboard') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-{{ auth()->user()->canManageContent() ? 'check text-green-500' : 'times text-red-500' }} w-5"></i>
                    <span class="text-gray-700">{{ __('dashboard.manage_content') }}</span>
                </div>
                @if (auth()->user()->canManageSettings())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('dashboard.manage_settings') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canManageSections())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('dashboard.manage_sections') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canViewAllRevisions())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('dashboard.view_revisions') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canRollback())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">الـ Rollback</span>
                    </div>
                @endif
                @if (auth()->user()->canManageUsers())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('dashboard.manage_users') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- الأنشطة الأخيرة (اختياري) -->
    <div class="bg-gray-200 rounded-lg shadow p-6 mb-6">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b">
            <i class="fas fa-clock text-2xl text-blue-600"></i>
            <h5 class="text-lg font-semibold text-gray-800">الأنشطة الأخيرة</h5>
        </div>
        <div class="text-center py-8">
            <p class="text-gray-500">لا توجد أنشطة حالياً</p>
        </div>
    </div>
@endsection
