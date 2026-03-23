@extends('dashboard.layout.master')

@section('title', __('main.my_profile'))

@push('styles')
    <style>
        .profileEditApp {
            width: 70%;
        }

        @media (max-width: 768px) {
            .profileEditApp {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('main.my_profile') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('main.manage_your_profile') }}</p>
        </div>

        <!-- Main Content Grid -->
        <div class="flex flex-col gap-6 profileEditApp">
            <!-- Sidebar - Profile Photo & Quick Actions -->
            <div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Profile Photo -->
                    <div class="px-6 pb-6 pt-0">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center -mt-12 mb-4">
                            @if ($user->photo && checkExistFile($user->photo))
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                @if ($user->photo)
                                    <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-3xl text-gray-600"></i>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="text-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600 mt-1 email">{{ $user->email }}</p>
                            <div class="mt-3">
                                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                    {{ __('main.' . strtolower($user->role)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">{{ __('main.join_date') }}:</span>
                                <span class="font-medium text-gray-900">
                                    {{ $user->created_at->diffForHumans() }} -
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">{{ __('main.last_login') }}:</span>
                                <span class="font-medium text-gray-900">
                                    @if ($user->last_login_at)
                                        {{ $user->last_login_at->diffForHumans() }} -
                                        {{ $user->last_login_at->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-gray-400">{{ __('main.never') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="{{ route('dashboard.profile.edit') }}"
                                class="w-full inline-block text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                                <i class="fas fa-edit mx-2"></i>
                                {{ __('main.edit_profile') }}
                            </a>
                            <a href="{{ route('dashboard.profile.activity') }}"
                                class="w-full inline-block text-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                                <i class="fas fa-history mx-2"></i>
                                {{ __('main.view_activity') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content - Profile Details -->
            <div>
                <!-- Personal Information Card -->
                <div class="bg-gray-100 rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-4 ">
                        <i class="fas fa-user-circle text-indigo-600 mx-3"></i>
                        {{ __('main.personal_information') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="bg-gray-200 p-4 rounded-sm">
                            <label class="text-sm font-medium text-gray-700">{{ __('main.name') }}</label>
                            <p class="mt-2 text-gray-900 font-medium">{{ ucfirst($user->name ?? '--') }}</p>
                        </div>

                        <!-- Email -->
                        <div class="bg-gray-200 p-4 rounded-sm">
                            <label class="text-sm font-medium text-gray-700">{{ __('main.email') }}</label>
                            <p class="mt-2 text-gray-900 font-medium">
                                <a href="mailto:{{ $user->email }}" target="_blank" class="inline-block text-blue-600 hover:underline font-medium">
                                    {!! limitedText($user->email ?? '--', 30) !!}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                </a>
                            </p>
                        </div>

                        <!-- Phone -->
                        <div class="bg-gray-200 p-4 rounded-sm">
                            <label class="text-sm font-medium text-gray-700">{{ __('main.phone') }}</label>
                            <p class="mt-2 text-gray-900 font-medium">
                                @if ($user->phone)
                                    <a href="tel:{{ $user->phone }}" target="_blank" class="inline-block text-blue-600 hover:underline font-medium">
                                        {!! limitedText($user->phone ?? '--', 30) !!}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">{{ __('main.not_provided') }}</span>
                                @endif
                            </p>
                        </div>

                        <!-- Mobile -->
                        <div class="bg-gray-200 p-4 rounded-sm">
                            <label class="text-sm font-medium text-gray-700">{{ __('main.mobile') }}</label>
                            <p class="mt-2 text-gray-900 font-medium">
                                @if ($user->mobile)
                                    <a href="tel:{{ $user->mobile }}" target="_blank" class="inline-block text-blue-600 hover:underline font-medium">
                                        {!! limitedText($user->mobile ?? '--', 30) !!}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">{{ __('main.not_provided') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-700">{{ __('main.address') }}</label>
                        <p class="mt-2 text-gray-900 font-medium">
                            @if ($user->address)
                                {!! $user->address !!}
                            @else
                                <span class="text-gray-400 italic">{{ __('main.not_provided') }}</span>
                            @endif
                        </p>
                    </div>

                    <!-- Bio -->
                    @if ($user->bio)
                        <div class="mt-6">
                            <label class="text-sm font-medium text-gray-700">{{ __('main.bio') }}</label>
                            <div class="mt-2 text-gray-900 prose prose-sm max-w-none">
                                {!! $user->bio !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Account Settings Card -->
                <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-4 ">
                        <i class="fas fa-lock text-indigo-600 mx-3"></i>
                        {{ __('main.account_settings') }}
                    </h3>

                    <div class="space-y-4">
                        <!-- Email Verification Status -->
                        <div class="flex items-center justify-between p-4 bg-gray-200 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ __('main.email_verified') }}</p>
                                <p class="text-sm text-gray-600">{{ __('main.verify_your_email_address') }}</p>
                            </div>
                            @if ($user->email_verified_at)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-check-circle mx-2"></i>{{ __('main.verified') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mx-2"></i>{{ __('main.unverified') }}
                                </span>
                            @endif
                        </div>

                        <!-- Change Password -->
                        <div class="flex items-center justify-between p-4 bg-gray-200 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ __('main.change_password') }}</p>
                                <p class="text-sm text-gray-600">{{ __('main.update_your_password') }}</p>
                            </div>
                            <a href="{{ route('dashboard.profile.edit') . '#forget-password' }}" class="px-4 py-2 text-indigo-600 font-medium hover:text-indigo-700 transition">
                                {{ __('main.change') }}
                            </a>
                        </div>

                        <!-- Language Preference -->
                        <div class="flex items-center justify-between p-4 bg-gray-200 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ __('main.language_preference') }}</p>
                                <p class="text-sm text-gray-600">{{ __('main.select_your_preferred_language') }}</p>
                            </div>
                            <div class="flex gap-2">
                                @foreach (config('languages') as $lang => $language)
                                    <a href="{{ route('locale.change', $lang) }}"
                                        class="px-3 py-1 rounded text-sm font-medium transition {{ app()->getLocale() === $lang ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                        {{ app()->getLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
