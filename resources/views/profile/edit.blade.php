@extends('dashboard.layout.master')

@section('title', __('main.edit_profile'))

@section('content')
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('dashboard.profile.show') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center mb-4">
                <i class="fas fa-arrow-right mx-2"></i>{{ __('main.back') }}
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('main.edit_profile') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('main.update_your_profile_information') }}</p>
        </div>

        <div class="grid md:grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Avatar Upload Card -->
            <div class="lg:col-span-1">
                <div class="bg-gray-100 rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-4">
                        <i class="fas fa-image text-indigo-600 mx-3"></i>
                        {{ __('main.profile_photo') }}
                    </h3>

                    <!-- Current Photo -->
                    <div class="mb-6 text-center">
                        @if ($user->photo)
                            <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}" id="photoPreview"
                                class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-lg object-cover mx-auto">
                        @else
                            <div id="photoPreview" class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-lg bg-gray-300 flex items-center justify-center mx-auto">
                                <i class="fas fa-user text-5xl text-gray-600"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('dashboard.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        @method('POST')

                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('main.choose_photo') }}
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="previewPhoto(this)">
                            @error('photo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-2">{{ __('main.max_5mb') }}</p>
                        </div>

                        <button type="submit" class="cursor-pointer w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-upload mx-2"></i>{{ __('main.upload_photo') }}
                        </button>
                    </form>

                    <!-- Delete Photo Button -->
                    @if ($user->photo)
                        <form action="{{ route('dashboard.profile.deletePhoto') }}" method="POST" class="mt-3" onsubmit="return confirm('{{ __('main.are_you_sure') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                <i class="fas fa-trash mx-2"></i>{{ __('main.delete_photo') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2">
                <div class="bg-gray-100 rounded-lg shadow-lg p-6">
                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-4">
                                <i class="fas fa-user text-indigo-600 mx-3"></i>
                                {{ __('main.personal_information') }}
                            </h3>

                            <!-- Name -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('main.enter_your_name') }}">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.email') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('main.enter_your_email') }}">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Grid for Phone and Mobile -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('main.phone') }}
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+1 (555) 000-0000">
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mobile -->
                                <div>
                                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('main.mobile') }}
                                    </label>
                                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+1 (555) 000-0000">
                                    @error('mobile')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.address') }}
                                </label>
                                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('main.enter_your_address') }}">
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div class="mb-6">
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.bio') }}
                                </label>
                                <textarea id="bio" name="bio" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 rich-editor"
                                    placeholder="{{ __('main.tell_us_about_yourself') }}">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Language Preferences Section -->
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-4">
                                <i class="fas fa-globe text-indigo-600 mx-3"></i>
                                {{ __('main.language_preferences') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Website Locale -->
                                <div>
                                    <label for="website_locale" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('main.website_language') }}
                                    </label>
                                    <select id="website_locale" name="website_locale" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">{{ __('main.select') }}</option>
                                        <option value="ar" {{ old('website_locale', $user->website_locale) === 'ar' ? 'selected' : '' }}>
                                            العربية
                                        </option>
                                        <option value="en" {{ old('website_locale', $user->website_locale) === 'en' ? 'selected' : '' }}>
                                            English
                                        </option>
                                    </select>
                                </div>

                                <!-- Dashboard Locale -->
                                <div>
                                    <label for="dashboard_locale" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('main.dashboard_language') }}
                                    </label>
                                    <select id="dashboard_locale" name="dashboard_locale"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">{{ __('main.select') }}</option>
                                        <option value="ar" {{ old('dashboard_locale', $user->dashboard_locale) === 'ar' ? 'selected' : '' }}>
                                            العربية
                                        </option>
                                        <option value="en" {{ old('dashboard_locale', $user->dashboard_locale) === 'en' ? 'selected' : '' }}>
                                            English
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="px-6 py-2 cursor-pointer bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center">
                                <i class="fas fa-save mx-2"></i>{{ __('main.save_changes') }}
                            </button>
                            <a href="{{ route('dashboard.profile.show') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="bg-gray-100 rounded-lg shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-4">
                        <i class="fas fa-lock text-indigo-600 mx-3"></i>
                        {{ __('main.change_password') }}
                    </h3>

                    <form action="{{ route('dashboard.profile.changePassword') }}" method="POST">
                        @csrf

                        <!-- Current Password -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('main.current_password') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('main.enter_current_password') }}">
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('main.new_password') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="{{ __('main.enter_new_password') }}">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('main.confirm_password') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('main.confirm_new_password') }}">
                            @error('password_confirmation')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="cursor-pointer px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-key mx-2"></i>{{ __('main.update_password') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewPhoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('photoPreview').innerHTML =
                            `<img src="${e.target.result}" alt="Preview" class="w-32 h-32 rounded-full border-4 border-indigo-100 shadow-lg object-cover">`;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
