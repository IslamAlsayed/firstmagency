@extends('dashboard.layout.master')

@section('title', __('main.account_activity'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('dashboard.profile.show') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center mb-4">
                    <i class="fas fa-arrow-right mx-2"></i>{{ __('main.back') }}
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('main.account_activity') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('main.monitor_your_account_activity') }}</p>
            </div>

            <!-- Activity Summary Cards -->
            <div class="flex flex-wrap gap-6 mb-8">
                <!-- Join Date Card -->
                <div class="flex-1 bg-gray-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">{{ __('main.joined_on') }}</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $joinDate }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Last Login Card -->
                <div class="flex-1 bg-gray-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">{{ __('main.last_login') }}</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">
                                @if ($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, Y') }}
                                @else
                                    <span class="text-base text-gray-400">{{ __('main.never') }}</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($user->last_login_at)
                                    {{ $user->last_login_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-sign-in-alt text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Account Status Card -->
                <div class="flex-1 bg-gray-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">{{ __('main.account_status') }}</p>
                            <div class="mt-2 flex items-center">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mx-2"></i>
                                        {{ __('main.active') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-times-circle mx-2"></i>
                                        {{ __('main.inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-gray-100 rounded-lg shadow-lg p-8 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mx-3"></i>
                    {{ __('main.account_information') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- User Information -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase">{{ __('main.user_information') }}</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.user_id') }}:</span>
                                <span class="text-gray-900 font-medium">#{{ $user->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.name') }}:</span>
                                <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.email') }}:</span>
                                <span class="text-gray-900 font-medium">
                                    <a href="mailto:{{ $user->email }}" target="_blank" class="inline-block text-blue-600 hover:underline font-medium">
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                        {{ $user->email }}
                                    </a>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.role') }}:</span>
                                <span class="text-gray-900 font-medium capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Login Information -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 uppercase">{{ __('main.login_information') }}</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.join_date') }}:</span>
                                <span class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.last_login') }}:</span>
                                <span class="text-gray-900 font-medium">
                                    @if ($user->last_login_at)
                                        {{ $user->last_login_at->format('M d, Y H:i:s') }}
                                    @else
                                        <span class="text-gray-400">{{ __('main.never') }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.last_login_ip') }}:</span>
                                <span class="text-gray-900 font-medium">
                                    @if ($user->last_login_ip)
                                        {{ $user->last_login_ip }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('main.password_changed') }}:</span>
                                <span class="text-gray-900 font-medium">
                                    @if ($user->password_changed_at)
                                        {{ $user->password_changed_at->format('M d, Y') }}
                                    @else
                                        <span class="text-gray-400">{{ __('main.never') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Recommendations -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                    <i class="fas fa-shield-alt text-blue-600 mx-3"></i>
                    {{ __('main.security_recommendations') }}
                </h3>
                <ul class="space-y-3 text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mx-3 mt-1"></i>
                        <span>{{ __('main.security_strong_password') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mx-3 mt-1"></i>
                        <span>{{ __('main.security_verify_email') }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-blue-600 mx-3 mt-1"></i>
                        <span>{{ __('main.security_monitor_activity') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Action Links -->
            <div class="flex gap-4">
                <a href="{{ route('dashboard.profile.edit') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-edit mx-2"></i>{{ __('main.edit_profile') }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="fas fa-sign-out-alt mx-2"></i>{{ __('main.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
