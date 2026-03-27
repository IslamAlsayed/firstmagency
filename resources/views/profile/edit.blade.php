@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.profile')]))

@include('profile._theme')

@section('content')
    <div class="profile-shell">
        <section class="profile-hero profile-animate">
            <div class="profile-hero-grid">
                <div>
                    <a href="{{ route('dashboard.profile.show') }}" class="profile-kicker"><i class="fas fa-arrow-left-long"></i> {{ __('main.back') }}</a>
                    <h1 class="profile-title">{{ __('main.edit_type', ['type' => __('main.profile')]) }}</h1>
                    <p class="profile-subtitle">{{ __('main.update_your_profile_information') }}</p>

                    <div class="profile-hero-actions">
                        <a href="{{ route('dashboard.profile.show') }}" class="profile-action"><i class="fas fa-user-pen"></i>{{ __('main.personal_information') }}</a>
                        {{-- <a href="{{ route('dashboard.profile.edit') }}" class="profile-action-secondary" data-password-jump><i class="fas fa-key"></i>{{ __('main.change_password') }}</a> --}}

                        <form method="POST" action="{{ route('logout') }}" class="">
                            @csrf
                            <button type="submit" class="profile-danger menu-link w-full h-full cursor-pointer">
                                <i class="ph-bold ph-sign-out"></i>
                                &nbsp;{{ __('main.sign_out') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="profile-side-card">
                    <div class="profile-avatar-wrap">
                        <div class="profile-upload-preview" id="photoPreview">
                            @if ($user->photo && checkExistFile($user->photo))
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                            @elseif ($user->photo)
                                <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}">
                            @else
                                <i class="fas fa-user text-5xl"></i>
                            @endif
                        </div>

                        <div>
                            <div class="text-sm opacity-80">{{ __('main.profile_photo') }}</div>
                            <div class="text-xl font-black">{{ $user->name }}</div>
                            {{-- <span class="profile-badge"><i class="fas fa-image"></i> {{ __('main.upload_photo') }}</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="profile-grid">
            <div class="flex flex-col gap-6">
                <section class="profile-form-panel profile-animate profile-delay-1">
                    <div class="profile-panel-head">
                        <div class="profile-panel-title">
                            <div class="profile-panel-icon"><i class="fas fa-camera-retro"></i></div>
                            <div>
                                <h3>{{ __('main.profile_photo') }}</h3>
                                <p>{{ __('main.choose_photo') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="profile-upload-card">
                        <div class="profile-upload-preview" id="photoPreviewPanel">
                            @if ($user->photo && checkExistFile($user->photo))
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                            @elseif ($user->photo)
                                <img src="{{ asset('assets/images/avatars/' . $user->photo) }}" alt="{{ $user->name }}">
                            @else
                                <i class="fas fa-user text-5xl"></i>
                            @endif
                        </div>

                        <div>
                            <form action="{{ route('dashboard.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                                @csrf
                                <div class="profile-field full">
                                    <label class="profile-label" for="photo">{{ __('main.choose_photo') }}</label>
                                    <input type="file" id="photo" name="photo" accept="image/*" class="profile-file" onchange="previewPhoto(this)">
                                    @error('photo')
                                        <div class="profile-error">{{ $message }}</div>
                                    @enderror
                                    <div class="profile-help">{{ __('main.max_5mb') }}</div>
                                </div>

                                <div class="flex flex-wrap gap-3 mt-4">
                                    <button type="submit" class="profile-button cursor-pointer"><i class="fas fa-upload"></i>{{ __('main.upload_photo') }}</button>
                                </div>
                            </form>

                            @if ($user->photo)
                                <form action="{{ route('dashboard.profile.deletePhoto') }}" method="POST" class="mt-3" onsubmit="return confirm('{{ __('main.are_you_sure') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="profile-danger cursor-pointer"><i class="fas fa-trash"></i>{{ __('main.delete_photo') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="profile-form-panel profile-animate profile-delay-2" id="profile-form">
                    <div class="profile-panel-head">
                        <div class="profile-panel-title">
                            <div class="profile-panel-icon"><i class="fas fa-user-gear"></i></div>
                            <div>
                                <h3>{{ __('main.personal_information') }}</h3>
                                <p>{{ __('main.update_your_profile_information') }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="profile-form-grid">
                            <div class="profile-field">
                                <label class="profile-label" for="name">{{ __('main.name') }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="profile-input" placeholder="{{ __('main.enter_your_name') }}">
                                @error('name')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="email">{{ __('main.email') }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="profile-input" placeholder="{{ __('main.enter_your_email') }}">
                                @error('email')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="phone">{{ __('main.phone') }}</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="profile-input" placeholder="+1 (555) 000-0000">
                                @error('phone')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="mobile">{{ __('main.mobile') }}</label>
                                <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="profile-input" placeholder="+1 (555) 000-0000">
                                @error('mobile')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field full">
                                <label class="profile-label" for="address">{{ __('main.address') }}</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" class="profile-input"
                                    placeholder="{{ __('main.enter_your_address') }}">
                                @error('address')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field full">
                                <label class="profile-label" for="bio">{{ __('main.bio') }}</label>
                                <textarea id="bio" name="bio" rows="5" class="profile-textarea rich-editor" placeholder="{{ __('main.tell_us_about_yourself') }}">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="website_locale">{{ __('main.website_language') }}</label>
                                <select id="website_locale" name="website_locale" class="profile-select">
                                    <option value="">{{ __('main.select') }}</option>
                                    @foreach (config('languages') as $code => $language)
                                        <option value="{{ $code }}" {{ old('website_locale', $user->website_locale) === $code ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="dashboard_locale">{{ __('main.dashboard_language') }}</label>
                                <select id="dashboard_locale" name="dashboard_locale" class="profile-select">
                                    <option value="">{{ __('main.select') }}</option>
                                    @foreach (config('languages') as $code => $language)
                                        <option value="{{ $code }}" {{ old('dashboard_locale', $user->dashboard_locale) === $code ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $language['name_ar'] : $language['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 mt-6">
                            <button type="submit" class="profile-button cursor-pointer"><i class="fas fa-floppy-disk"></i>{{ __('main.save_changes') }}</button>
                            <a href="{{ route('dashboard.profile.show') }}" class="profile-action-secondary">{{ __('main.cancel') }}</a>
                        </div>
                    </form>
                </section>
            </div>

            <section class="profile-form-panel profile-animate profile-delay-3" id="change-password">
                <div class="profile-panel-head">
                    <div class="profile-panel-title">
                        <div class="profile-panel-icon"><i class="fas fa-key"></i></div>
                        <div>
                            <h3>{{ __('main.change_password') }}</h3>
                            <p>{{ __('main.update_your_password') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dashboard.profile.changePassword') }}" method="POST">
                    @csrf
                    <div class="profile-form-grid">
                        <div class="profile-field full">
                            <label class="profile-label" for="current_password">{{ __('main.current_password') }}</label>
                            <input type="password" id="current_password" name="current_password" class="profile-input" placeholder="{{ __('main.enter_current_password') }}">
                            @error('current_password')
                                <div class="profile-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label class="profile-label" for="password">{{ __('main.new_password') }}</label>
                            <input type="password" id="password" name="password" class="profile-input" placeholder="{{ __('main.enter_new_password') }}">
                            @error('password')
                                <div class="profile-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label class="profile-label" for="password_confirmation">{{ __('main.confirm_password') }}</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="profile-input" placeholder="{{ __('main.confirm_new_password') }}">
                            @error('password_confirmation')
                                <div class="profile-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-security-list mt-5">
                        <ul>
                            <li><i class="fas fa-shield-check text-emerald-600 mt-1"></i><span>{{ __('main.security_strong_password') }}</span></li>
                            <li><i class="fas fa-user-lock text-sky-600 mt-1"></i><span>{{ __('main.security_monitor_activity') }}</span></li>
                        </ul>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="profile-button cursor-pointer"><i class="fas fa-key"></i>{{ __('main.update_password') }}</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewPhoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const markup = `<img src="${e.target.result}" alt="Preview">`;
                        const heroPreview = document.getElementById('photoPreview');
                        const panelPreview = document.getElementById('photoPreviewPanel');
                        if (heroPreview) heroPreview.innerHTML = markup;
                        if (panelPreview) panelPreview.innerHTML = markup;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const passwordPanel = document.getElementById('change-password');
                if (!passwordPanel) return;

                const triggerFlash = () => {
                    passwordPanel.classList.remove('flash-on-load');
                    requestAnimationFrame(() => {
                        passwordPanel.classList.add('flash-on-load');
                    });
                };

                document.querySelectorAll('[data-password-jump]').forEach((link) => {
                    link.addEventListener('click', triggerFlash);
                });
            });
        </script>
    @endpush
@endsection
