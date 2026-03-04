@extends('dashboard.layout.master')

@section('title', __('main.settings'))

@section('page-title', '⚡ ' . __('main.settings'))

@section('content')
    <div class="background rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-custom-b-1">
            <h5 class="text-2xl font-semibold text-blue-900">
                <i class="fas fa-cog"></i>
                {{ __('main.settings_management') }}
            </h5>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 gap-4">
                <!-- General Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-sliders-h text-green-500"></i>
                        {{ __('main.general_settings') }}
                    </h6>
                    <form action="{{ route('dashboard.settings.updateGeneral') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="site-email" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.site_email') }}</label>
                                <input type="email" id="site-email" name="site_email"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="email@example.com" value="{{ $settings->site_email ?? 'info@firstmagency.com' }}">
                            </div>
                            <div>
                                <label for="site-whatsapp" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.site_whatsapp') }}</label>
                                <input type="tel" id="site-whatsapp" name="site_whatsapp"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="WhatsApp Number" value="{{ $settings->site_whatsapp ?? '201212601601' }}">
                            </div>
                            <div>
                                <label for="site-phone" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.site_phone') }}</label>
                                <input type="tel" id="site-phone" name="site_phone"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="Phone Number" value="{{ $settings->site_phone ?? '201212602602' }}">
                            </div>
                        </div>

                        <div class="col-span-full">
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'site_description',
                                'value' => $settings->site_description,
                                'classes' => 'mb-4',
                            ])

                            @include('dashboard.components.input-text-editor', [
                                'name' => 'site_description_ar',
                                'value' => $settings->site_description_ar,
                            ])
                        </div>

                        <div>
                            <label class="kt-label mb-2">{{ __('main.button_display_mode') }}</label>
                            <select name="button_display_mode" id="button_display_mode" class="kt-select basic-single" data-kt-select="true"
                                data-kt-select-placeholder="{{ __('main.button_display_mode') }}">
                                <option value="text" {{ getActiveUser()->button_display_mode == 'text' ? 'selected' : '' }}>
                                    {{ __('main.text') }}
                                </option>
                                <option value="icon" {{ getActiveUser()->button_display_mode == 'icon' ? 'selected' : '' }}>
                                    {{ __('main.icon') }}
                                </option>
                                <option value="both" {{ getActiveUser()->button_display_mode == 'both' ? 'selected' : '' }}>
                                    {{ __('main.both') }}
                                </option>
                            </select>
                        </div>

                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Debug Mode Toggle -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-bug text-red-500"></i>
                        Debug Mode
                    </h6>
                    <form action="{{ route('dashboard.settings.toggleDebugMode') }}" method="POST" class="space-y-5">
                        @csrf
                        <p class="text-sm text-gray-500">
                            When enabled, section flags will be visible on the website for debugging purposes.
                        </p>
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer {{ $settings->debug_mode ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-semibold rounded-[9px] shadow-md">
                            <i class="fas {{ $settings->debug_mode ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                            {{ $settings->debug_mode ? 'Disable Debug Mode' : 'Enable Debug Mode' }}
                        </button>
                    </form>
                </div>

                <!-- Debug IPs Configuration -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-network-wired text-blue-500"></i>
                        Debug Mode - Allowed IPs
                    </h6>
                    <form action="{{ route('dashboard.settings.updateDebugIps') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-3">
                                <strong>Your Current IP:</strong> <span
                                    class="font-mono bg-blue-100 px-3 py-1 rounded text-blue-700">{{ getCurrentClientIp() }}</span>
                            </p>
                            <p class="text-sm text-gray-500">
                                If left empty, debug flags will be visible to everyone when Debug Mode is enabled. Otherwise, add specific IPs to restrict access.
                            </p>
                        </div>

                        <div>
                            <label for="debug-ips" class="block text-sm font-semibold text-gray-600 mb-2">Allowed IPs (one per line)</label>
                            <textarea id="debug-ips" name="debug_ips"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm font-mono text-sm"
                                rows="4" placeholder="127.0.0.1&#10;192.168.1.100">{{ $settings->debug_ips ? implode("\n", json_decode($settings->debug_ips, true)) : '' }}</textarea>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <p class="text-sm text-blue-700">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Quick add:</strong> Click the button below to add your current IP
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary font-semibold rounded-[9px] shadow-md">
                                <i class="fas fa-save"></i>
                                Save IPs
                            </button>
                            <button type="button" id="add-my-ip-btn"
                                class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-green-600 hover:bg-green-700 font-semibold rounded-[9px] shadow-md">
                                <i class="fas fa-plus"></i>
                                Add My IP
                            </button>
                        </div>
                    </form>

                    <!-- Hidden form for Add My IP -->
                    <form id="add-my-ip-form" action="{{ route('dashboard.settings.addMyIpToDebug') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>

                <!-- About Us Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-info-circle text-amber-500"></i>
                        {{ __('main.about_us') }}
                    </h6>
                    <form action="{{ route('dashboard.settings.updateAboutUs') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- About Us Title --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="about-us-title" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }} (EN)</label>
                                <input type="text" id="about-us-title" name="about_us_title"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="About Us Title" value="{{ $settings->about_us_title ?? '' }}">
                            </div>
                            <div>
                                <label for="about-us-title-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }}
                                    (AR)</label>
                                <input type="text" id="about-us-title-ar" name="about_us_title_ar"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="عنوان عن الشركة" value="{{ $settings->about_us_title_ar ?? '' }}">
                            </div>
                        </div>

                        {{-- About Us Description (English) --}}
                        <div class="col-span-full">
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'about_us_description',
                                'value' => $settings->about_us_description,
                                'classes' => 'mb-4',
                            ])

                            @include('dashboard.components.input-text-editor', [
                                'name' => 'about_us_description_ar',
                                'value' => $settings->about_us_description_ar,
                            ])
                        </div>

                        {{-- About Us Image --}}
                        @include('dashboard.components.photo', ['record' => $settings, 'column' => 'about_us_image'])

                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Colors Website -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-custom-b-1">
                        <i class="fas fa-palette text-blue-500"></i>
                        {{ __('main.color_website') }}
                    </h6>
                    <form action="{{ route('dashboard.settings.updateColorsWebsite') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center flex-wrap gap-4">
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.main_color') }}</label>
                                <input type="color" id="main-color" name="main_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->main_color ?? '#d05423' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="dark-main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.dark_main_color') }}</label>
                                <input type="color" id="dark-main-color" name="dark_main_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->dark_main_color ?? '#96310E' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="light-main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.light_main_color') }}</label>
                                <input type="color" id="light-main-color" name="light_main_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->light_main_color ?? '#F97316' }}">
                            </div>
                        </div>
                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Colors Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-custom-b-1">
                        <i class="fas fa-palette text-blue-500"></i>
                        {{ __('main.color_dashboard') }}
                    </h6>
                    <form action="{{ route('dashboard.settings.updateColors') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center flex-wrap gap-4">
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="primary-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.primary_color') }}</label>
                                <input type="color" id="primary-color" name="primary_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->primary_color ?? '#6f42c1' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="secondary-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.secondary_color') }}</label>
                                <input type="color" id="secondary-color" name="secondary_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->secondary_color ?? '#6c757d' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="success-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.success_color') }}</label>
                                <input type="color" id="success-color" name="success_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->success_color ?? '#198754' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="danger-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.danger_color') }}</label>
                                <input type="color" id="danger-color" name="danger_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->danger_color ?? '#dc3545' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="warning-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.warning_color') }}</label>
                                <input type="color" id="warning-color" name="warning_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->warning_color ?? '#ffc107' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="info-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.info_color') }}</label>
                                <input type="color" id="info-color" name="info_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->info_color ?? '#0dcaf0' }}">
                            </div>
                            <div class="flex-1 text-nowrap" style="min-width: 100px;">
                                <label for="accent-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.accent_color') }}</label>
                                <input type="color" id="accent-color" name="accent_color"
                                    class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                    value="{{ $settings->accent_color ?? '#dc3545' }}">
                            </div>
                        </div>
                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Fonts Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-font text-purple-500"></i>
                        {{ __('main.font_settings') }}
                    </h6>
                    <form action="{{ route('dashboard.settings.updateFonts') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="font-url" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.font_url') }}</label>
                            <input type="url" id="font-url" name="font_url"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="https://fonts.googleapis.com/css2?family=Tajawal"
                                value="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800&family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap' }}">
                        </div>
                        <div>
                            <label for="font-name" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.font_name') }}</label>
                            <input type="text" id="font-name" name="font_name"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="Tajawal" value="{{ $settings->font_name ?? 'Tajawal' }}">
                        </div>
                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                {{-- @include('dashboard.sections.debug-table') --}}

                <!-- Inline Padding Sections Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <h6 class="text-xl font-semibold text-gray-600 pb-2 border-b-2 border-purple-300">
                            <i class="fas fa-arrows-alt-h text-purple-500"></i>
                            Inline Padding Sections Settings
                        </h6>

                        <input type="text" id="inline-padding-search" placeholder="Search sections..."
                            class="w-[280px] px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm">
                    </div>

                    <form action="{{ route('dashboard.settings.updateInlinePadding') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-lowercase" id="inline-padding-sections">
                            {{-- Home Page Inline Padding Settings --}}
                            <div class="inline-padding-section" data-section="flag-hero">
                                <label for="home-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-hero</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-hero-section" name="home_hero_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="120" value="{{ $settings->home_hero_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-services">
                                <label for="home-services-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-services</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-services-section" name="home_services_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->home_services_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-projects">
                                <label for="home-projects-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-projects</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-projects-section" name="home_projects_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="20" value="{{ $settings->home_projects_section ?? '20' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-reviews">
                                <label for="home-reviews-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-reviews</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-reviews-section" name="home_reviews_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->home_reviews_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-clients">
                                <label for="home-clients-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-clients</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-clients-section" name="home_clients_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="120" value="{{ $settings->home_clients_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-about-us">
                                <label for="about-us-steps" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-about-us</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-steps" name="about_us_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-partners">
                                <label for="about-us-partners" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-partners</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-partners" name="about_us_partners_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_partners_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-line-works">
                                <label for="line-works-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-line-works</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="line-works-section" name="work_lines_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->work_lines_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-portfolio">
                                <label for="portfolio-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-portfolio</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="portfolio-section" name="portfolio_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->portfolio_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-articles">
                                <label for="blog-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-articles</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="blog-articles-section" name="blog_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->blog_articles_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-contact">
                                <label for="contact-page" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-contact</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="contact-page" name="contact_page_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->contact_page_section ?? '180' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-website-developer">
                                <label for="website-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-website-developer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-developer-section" name="website_developer_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_developer_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-programming">
                                <label for="website-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-programming</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-programming-section" name="website_programming_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_programming_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-website-designer">
                                <label for="website-design-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-website-designer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-design-section" name="website_design_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_design_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-important-articles">
                                <label for="website-important-articles-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-important-articles</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-important-articles-section" name="app_important_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->app_important_articles_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-faq">
                                <label for="faqs-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-faq</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="faqs-section" name="faqs_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->faqs_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-app-developer">
                                <label for="app-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-app-developer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="app-developer-section" name="feature_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->feature_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-packages">
                                <label for="packages-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-packages</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="packages-section" name="packages_hosting_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->packages_hosting_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-operating-systems">
                                <label for="operations-systems-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-operating-systems</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="operations-systems-section" name="operations_systems_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->operations_systems_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-your-domain">
                                <label for="your-domain-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-your-domain</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="your-domain-section" name="your_domain_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->your_domain_section ?? '240' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-official-domains">
                                <label for="official-domains-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-official-domains</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="official-domains-section" name="pest_domains_official_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->pest_domains_official_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-pest-domains">
                                <label for="pest-domains-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-pest-domains</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="pest-domains-section" name="pest_domains_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->pest_domains_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-why-us">
                                <label for="why-us-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-why-us</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="why-us-section" name="why_us_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->why_us_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-platform-management">
                                <label for="platform-management-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-platform-management</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="platform-management-section" name="platform_management_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->platform_management_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-our-services-marketing">
                                <label for="our-services-marketing-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-our-services-marketing</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="our-services-marketing-section" name="our_services_marketing_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->our_services_marketing_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-marketing-hero">
                                <label for="marketing-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-marketing-hero</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="marketing-hero-section" name="marketing_hero_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->marketing_hero_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-order-app">
                                <label for="order-app-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-order-app</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="order-app-section" name="order_app_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->order_app_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-hosting-hero">
                                <label for="hosting-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-hosting-hero</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="hosting-hero-section" name="hosting_hero_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->hosting_hero_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-hosting-features">
                                <label for="hosting-features-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-hosting-features</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="hosting-features-section" name="hosting_features_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->hosting_features_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-categories-programming">
                                <label for="categories-programming-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-categories-programming</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="categories-programming-section" name="categories_programming_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->categories_programming_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-dont-worry-hosting">
                                <label for="dont-worry-hosting-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-dont-worry-hosting</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="dont-worry-hosting-section" name="dont_worry_hosting_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->dont_worry_hosting_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-easy-management">
                                <label for="easy-management-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-easy-management</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="easy-management-section" name="easy_management_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->easy_management_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-important-articles-marketing">
                                <label for="important-articles-marketing-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-important-articles-marketing</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="important-articles-marketing-section" name="important_articles_marketing_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->important_articles_marketing_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-project-steps">
                                <label for="project-steps-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-project-steps</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="project-steps-section" name="project_steps_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->project_steps_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-ready-hosting">
                                <label for="ready-hosting-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-ready-hosting</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="ready-hosting-section" name="ready_hosting_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->ready_hosting_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-support-hosting">
                                <label for="support-hosting-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-support-hosting</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="support-hosting-section" name="support_hosting_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->support_hosting_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-work-line">
                                <label for="work-line-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-work-line</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="work-line-section" name="work_line_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->work_line_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-clients2">
                                <label for="clients2-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-clients2</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="clients2-section" name="clients_2_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->clients_2_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-step-work2">
                                <label for="step-work2-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1"
                                    style="font-size: 12px">
                                    <span>flag-step-work2</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="step-work2-section" name="step_work2_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->step_work2_section ?? '60' }}">
                            </div>
                        </div>
                        <button type="submit" toggle-button
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary: {{ $settings->primary_color ?? '#6f42c1' }};
            --secondary: {{ $settings->secondary_color ?? '#6c757d' }};
            --success: {{ $settings->success_color ?? '#198754' }};
            --danger: {{ $settings->danger_color ?? '#dc3545' }};
            --warning: {{ $settings->warning_color ?? '#ffc107' }};
            --info: {{ $settings->info_color ?? '#0dcaf0' }};
            --accent-color: {{ $settings->accent_color ?? '#dc3545' }};

            --main-color: {{ $settings->main_color ?? '#d05423' }};
            --dark-main-color: {{ $settings->dark_main_color ?? '#96310E' }};
            --light-main-color: {{ $settings->light_main_color ?? '#F97316' }};
        }

        /* Live preview styles */
        [style*="--primary"] {
            color: var(--primary);
        }

        [style*="--secondary"] {
            color: var(--secondary);
        }

        [style*="--success"] {
            color: var(--success);
        }

        [style*="--danger"] {
            color: var(--danger);
        }

        [style*="--warning"] {
            color: var(--warning);
        }

        [style*="--info"] {
            color: var(--info);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Live color preview
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard colors
            const dashboardColors = {
                'primary-color': '--primary',
                'secondary-color': '--secondary',
                'success-color': '--success',
                'danger-color': '--danger',
                'warning-color': '--warning',
                'info-color': '--info',
                'accent-color': '--accent-color'
            };

            // Website colors
            const websiteColors = {
                'main-color': '--main-color',
                'dark-main-color': '--dark-main-color',
                'light-main-color': '--light-main-color'
            };

            const allColors = {
                ...dashboardColors,
                ...websiteColors
            };

            Object.entries(allColors).forEach(([inputId, cssVar]) => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function(e) {
                        document.documentElement.style.setProperty(cssVar, e.target.value);
                    });
                }
            });
        });

        // Inline Padding Sections Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('inline-padding-search');
            const sections = document.querySelectorAll('.inline-padding-section');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase();
                    console.log('query ', query);
                    sections.forEach(section => {
                        const sectionName = section.getAttribute('data-section').toLowerCase();
                        if (sectionName.includes(query)) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            }

            // Handle Add My IP button
            const addMyIpBtn = document.getElementById('add-my-ip-btn');
            if (addMyIpBtn) {
                addMyIpBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = document.getElementById('add-my-ip-form');
                    if (form) {
                        form.submit();
                    }
                });
            }
        });
    </script>
@endpush
