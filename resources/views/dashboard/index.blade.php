@extends('dashboard.layout.master')

@section('title', __('main.dashboard'))
@section('page-title', '🏠 ' . __('main.dashboard'))

@section('content')
    <!-- {{ __('main.statistics') }} -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-primary rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">{{ __('main.total_users') }}</p>
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
                    <p class="text-red-100 text-sm font-medium">{{ __('main.superadmins') }}</p>
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
                    <p class="text-amber-100 text-sm font-medium">{{ __('main.admins') }}</p>
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
                    <p class="text-teal-100 text-sm font-medium">{{ __('main.content_managers') }}</p>
                    <p class="text-4xl font-bold mt-2">{{ $stats['content_managers'] ?? 0 }}</p>
                </div>
                <div class="rounded-lg p-4">
                    <i class="fas fa-pen text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- {{ __('main.account_info') }} -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- {{ __('main.account_info') }} -->
        <div class="bg-gray-200 rounded-lg shadow p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b">
                <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                <h5 class="text-lg font-semibold text-gray-800">{{ __('main.account_info') }}</h5>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('main.name') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->name }}</p>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('main.email') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->email }}</p>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('main.role') }}</p>
                    <span
                        class="inline-block bg-indigo-100 text-indigo-800 rounded-full px-3 py-1 text-sm font-medium mt-1">{{ auth()->user()->getRoleNameArabic() }}</span>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase">{{ __('main.join_date') }}</p>
                    <p class="text-gray-800 font-medium mt-1">{{ auth()->user()->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- الصلاحيات الخاصة بك -->
        <div class="bg-gray-200 rounded-lg shadow p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b">
                <i class="fas fa-lock text-2xl text-green-600"></i>
                <h5 class="text-lg font-semibold text-gray-800">{{ __('main.permissions') }}</h5>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <i class="fas fa-{{ auth()->user()->canAccessDashboard() ? 'check text-green-500' : 'times text-red-500' }} w-5"></i>
                    <span class="text-gray-700">{{ __('main.access_dashboard') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-{{ auth()->user()->canManageContent() ? 'check text-green-500' : 'times text-red-500' }} w-5"></i>
                    <span class="text-gray-700">{{ __('main.manage_content') }}</span>
                </div>
                @if (auth()->user()->canManageSettings())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('main.manage_settings') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canManageSections())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('main.manage_sections') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canViewAllRevisions())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('main.view_revisions') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canRollback())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('main.rollback_permission') }}</span>
                    </div>
                @endif
                @if (auth()->user()->canManageUsers())
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check text-green-500 w-5"></i>
                        <span class="text-gray-700">{{ __('main.manage_users') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- الأنشطة الأخيرة (اختياري) -->
    <div class="bg-gray-200 rounded-lg shadow p-6 mb-6">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b">
            <i class="fas fa-clock text-2xl text-blue-600"></i>
            <h5 class="text-lg font-semibold text-gray-800">{{ __('main.recent_activities') }}</h5>
        </div>
        <div class="text-center py-8">
            <p class="text-gray-500">{{ __('main.no_activities_currently') }}</p>
        </div>
    </div>
@endsection
