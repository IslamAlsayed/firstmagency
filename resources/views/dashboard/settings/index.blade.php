@extends('dashboard.layout.master')

@section('title', __('main.settings'))

@section('page-title', '⚡ ' . __('main.settings'))

@push('styles')
    <style>
        .toggle-icon {
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e5e7eb;
            border-radius: 9999px;
            transition: background-color 0.3s ease, transform 0.3s ease;

            &:hover {
                transform: translateY(-2px);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Main Grid: Sidebar + Content -->
    {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 p-4"> --}}
    <div class="grid grid-cols-1 gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 hidden">
            <div id="settings-sidebar" class="bg-gradient-to-b from-blue-50 to-purple-50 rounded-lg shadow-md p-4 border-2 border-blue-200">
                <h6 class="text-lg font-bold text-blue-900 mb-4">
                    <i class="fas fa-list"></i> {{ __('main.sections') }}
                </h6>
                <nav class="space-y-2">
                    <!-- General Settings -->
                    <a href="#section-general" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="general">
                        <i class="fas fa-sliders-h text-green-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.general_settings') }}</span>
                    </a>

                    <!-- Debug Mode -->
                    <a href="#section-debug-mode" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="debug-mode">
                        <i class="fas fa-bug text-red-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.debug_mode') }}</span>
                    </a>

                    <!-- Debug IPs -->
                    <a href="#section-debug-ips" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="debug-ips">
                        <i class="fas fa-network-wired text-blue-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.settings_debug_ips') }}</span>
                    </a>

                    <!-- About Us -->
                    <a href="#section-about-us" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="about-us">
                        <i class="fas fa-info-circle text-amber-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.about_us') }}</span>
                    </a>

                    <!-- Website Design -->
                    <a href="#section-website-design" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="website-design">
                        <i class="fas fa-laptop-code text-blue-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.website_design') }}</span>
                    </a>

                    <!-- Colors Website -->
                    <a href="#section-colors-website" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="colors-website">
                        <i class="fas fa-palette text-blue-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.color_website') }}</span>
                    </a>

                    <!-- Colors Dashboard -->
                    <a href="#section-colors-dashboard" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="colors-dashboard">
                        <i class="fas fa-palette text-purple-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.color_dashboard') }}</span>
                    </a>

                    <!-- Fonts -->
                    <a href="#section-fonts" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group" data-section="fonts">
                        <i class="fas fa-font text-purple-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.font_settings') }}</span>
                    </a>

                    <!-- Inline Padding -->
                    <a href="#section-inline-padding" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                        data-section="inline-padding">
                        <i class="fas fa-arrows-alt-h text-purple-500 group-hover:scale-110 transition"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ __('main.settings_inline_padding') }}</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        {{-- <div class="lg:col-span-3 space-y-6"> --}}
        <div class="space-y-6">
            <!-- General Settings -->
            <div class="bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-sliders-h text-green-500"></i>
                        {{ __('main.general_settings') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="general-settings-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>
                <form action="{{ route('dashboard.settings.updateGeneral') }}" method="POST" class="space-y-5" id="general-settings-section">
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
                                placeholder="{{ __('main.settings_whatsapp_number') }}" value="{{ $settings->site_whatsapp ?? '201212601601' }}">
                        </div>
                        <div>
                            <label for="site-phone" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.site_phone') }}</label>
                            <input type="tel" id="site-phone" name="site_phone"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="{{ __('main.settings_phone_number') }}" value="{{ $settings->site_phone ?? '201212602602' }}">
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
                        <select name="button_display_mode" id="button_display_mode" class="kt-select basic-single" data-kt-select="true" data-kt-select-placeholder="{{ __('main.button_display_mode') }}">
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

                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- About Us Settings -->
            <div class="bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-info-circle text-amber-500"></i>
                        {{ __('main.about_us') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="about-us-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>

                <form action="{{ route('dashboard.settings.updateAboutUs') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="about-us-section">
                    @csrf
                    @method('PUT')

                    {{-- About Us Title --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="about-us-title" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }} (EN)</label>
                            <input type="text" id="about-us-title" name="about_us_title"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="{{ __('main.settings_about_us_title_placeholder') }}" value="{{ $settings->about_us_title ?? '' }}">
                        </div>
                        <div>
                            <label for="about-us-title-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }}
                                (AR)</label>
                            <input type="text" id="about-us-title-ar" name="about_us_title_ar"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="{{ __('main.settings_about_us_title_ar_placeholder') }}" value="{{ $settings->about_us_title_ar ?? '' }}">
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

                    {{-- About Us Image 2 --}}
                    @include('dashboard.components.photo', ['record' => $settings, 'column' => 'about_us_image2'])

                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- Website Design Settings -->
            <div class="bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-laptop-code text-blue-500"></i>
                        {{ __('main.website_design_title') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="website-design-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>

                <form action="{{ route('dashboard.settings.updateWebsiteDesign') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="website-design-section">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4">
                        <!-- Tabs Navigation -->
                        @include('dashboard.components.tabs-navigation')

                        <!-- English Tab Content -->
                        <div class="language-content" data-lang="en">
                            <div class="grid gap-4">
                                {{-- Website Design Title EN --}}
                                <div>
                                    <label for="website-design-title" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.title') }}</label>
                                    <input type="text" id="website-design-title" name="website_design_title"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                        placeholder="{{ __('main.settings_website_design_title_placeholder') }}" value="{{ $settings->website_design_title ?? '' }}">
                                </div>

                                {{-- Website Design Heading EN --}}
                                <div>
                                    <label for="website-design-heading" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                    <input type="text" id="website-design-heading" name="website_design_heading"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                        placeholder="{{ __('main.settings_website_design_heading_placeholder') }}" value="{{ $settings->website_design_heading ?? '' }}">
                                </div>

                                {{-- Website Design Description EN --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'website_design_description',
                                    'value' => $settings->website_design_description ?? '',
                                    'classes' => 'mb-4',
                                ])
                            </div>
                        </div>

                        <!-- Arabic Tab Content -->
                        <div class="language-content hidden" data-lang="ar">
                            <div class="grid gap-4">
                                {{-- Website Design Title AR --}}
                                <div>
                                    <label for="website-design-title-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.title') }}</label>
                                    <input type="text" id="website-design-title-ar" name="website_design_title_ar"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                        placeholder="{{ __('main.settings_website_design_title_ar_placeholder') }}" value="{{ $settings->website_design_title_ar ?? '' }}">
                                </div>

                                {{-- Website Design Heading AR --}}
                                <div>
                                    <label for="website-design-heading-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                    <input type="text" id="website-design-heading-ar" name="website_design_heading_ar"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                        placeholder="{{ __('main.settings_website_design_heading_ar_placeholder') }}" value="{{ $settings->website_design_heading_ar ?? '' }}">
                                </div>

                                {{-- Website Design Description AR --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'website_design_description_ar',
                                    'value' => $settings->website_design_description_ar ?? '',
                                    'classes' => 'mb-4',
                                ])
                            </div>
                        </div>

                        {{-- Website Design Image --}}
                        @include('dashboard.components.photo', ['record' => $settings, 'column' => 'website_design_image'])

                        {{-- Website Design Years Experience --}}
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="website-design-years" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.website_design_years_experience') }}</label>
                                <input type="number" id="website-design-years" name="website_design_years_experience"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="8" value="{{ $settings->website_design_years_experience ?? 8 }}" min="0">
                            </div>
                            <div class="text-sm text-blue-600 bg-blue-50 p-3 rounded-lg">
                                <p><strong>{{ __('main.website_design_clients') }}:</strong> {{ App\Models\Client::count() }}</p>
                                <p><strong>{{ __('main.website_design_projects') }}:</strong> {{ App\Models\Project::count() }}</p>
                                <p><strong>{{ __('main.website_design_support_ticket') }}:</strong> {{ App\Models\Ticket::count() }}</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- Colors Website -->
            <div class="bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-palette text-blue-500"></i>
                        {{ __('main.color_website') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="colors-website-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>

                <form action="{{ route('dashboard.settings.updateColorsWebsite') }}" method="POST" class="space-y-5" id="colors-website-section">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center flex-wrap gap-4">
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.main_color') }}</label>
                            <input type="color" id="main-color" name="main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->main_color ?? '#d05423' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="dark-main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.dark_main_color') }}</label>
                            <input type="color" id="dark-main-color" name="dark_main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->dark_main_color ?? '#96310E' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="light-main-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.light_main_color') }}</label>
                            <input type="color" id="light-main-color" name="light_main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->light_main_color ?? '#F97316' }}">
                        </div>
                    </div>
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- Colors Settings -->
            <div class="hidden bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-palette text-blue-500"></i>
                        {{ __('main.color_dashboard') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="colors-dashboard-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>

                <form action="{{ route('dashboard.settings.updateColors') }}" method="POST" class="space-y-5" id="colors-dashboard-section">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center flex-wrap gap-4">
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="primary-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.primary_color') }}</label>
                            <input type="color" id="primary-color" name="primary_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->primary_color ?? '#6f42c1' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="secondary-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.secondary_color') }}</label>
                            <input type="color" id="secondary-color" name="secondary_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->secondary_color ?? '#6c757d' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="success-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.success_color') }}</label>
                            <input type="color" id="success-color" name="success_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->success_color ?? '#198754' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="danger-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.danger_color') }}</label>
                            <input type="color" id="danger-color" name="danger_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->danger_color ?? '#dc3545' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="warning-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.warning_color') }}</label>
                            <input type="color" id="warning-color" name="warning_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->warning_color ?? '#ffc107' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="info-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.info_color') }}</label>
                            <input type="color" id="info-color" name="info_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->info_color ?? '#0dcaf0' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="accent-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.accent_color') }}</label>
                            <input type="color" id="accent-color" name="accent_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->accent_color ?? '#dc3545' }}">
                        </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-4">
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="header-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.header_color') }}</label>
                            <input type="color" id="header-color" name="header_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->header_color ?? '#6f42c1' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="header-text-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.header_text_color') }}</label>
                            <input type="color" id="header-text-color" name="header_text_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->header_text_color ?? '#f7f7f7' }}">
                        </div>
                        {{-- <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="footer-color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.footer_color') }}</label>
                            <input type="color" id="footer-color" name="footer_color"
                                class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->footer_color ?? '#2d3748' }}">
                        </div> --}}
                    </div>
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- Fonts Settings -->
            <div class="bg-white radius-lg shadow-lg p-6">
                <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                    <div>
                        <i class="fas fa-font text-purple-500"></i>
                        {{ __('main.font_settings') }}
                    </div>

                    <div class="toggle-icon" toggle-button data-section="fonts-section">
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                </h6>

                <form action="{{ route('dashboard.settings.updateFonts') }}" method="POST" class="space-y-5" id="fonts-section">
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
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            {{-- form reset sidebar --}}
            @if (userSidebarPreference())
                <form action="{{ route('dashboard.sidebar.reset') }}" method="POST">
                    @csrf
                    <button type="submit" class="cursor-pointer flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-redo"></i> {{ __('main.reset_sort_sidebar_menu') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --dash_primary_color: {{ $settings->primary_color ?? '#fff' }};
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
        [style*="--dash_primary_color"] {
            color: var(--dash_primary_color);
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

        /* Custom Sidebar Fixed Position */
        #settings-sidebar {
            position: relative;
        }

        #settings-sidebar.fixed-sidebar {
            position: fixed;
            width: calc((100% - 48px) / 4);
            max-width: 280px;
            z-index: 40;
            top: 20px;
        }

        /* Sidebar Navigation Active State */
        .settings-nav-item {
            position: relative;
        }

        .settings-nav-item.active {
            background-color: rgb(191, 219, 254);
            border-left: 4px solid #3b82f6;
            padding-left: calc(1rem - 4px);
        }

        .settings-nav-item.active i {
            color: #1e40af !important;
        }

        .settings-nav-item.active span {
            color: #1e40af !important;
            font-weight: 700;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Custom Fixed Sidebar
        // document.addEventListener('DOMContentLoaded', function() {
        //     const sidebar = document.getElementById('settings-sidebar');
        //     const sidebarContainer = sidebar.parentElement;
        //     const contentContainer = document.querySelector('.lg\\:col-span-3');

        //     function handleSidebarPosition() {
        //         const sidebarRect = sidebar.getBoundingClientRect();
        //         const containerRect = sidebarContainer.getBoundingClientRect();
        //         const contentRect = contentContainer.getBoundingClientRect();

        //         // Check if we need to make sidebar fixed
        //         if (window.scrollY > sidebarContainer.offsetTop && contentRect.bottom > window.innerHeight) {
        //             sidebar.classList.add('fixed-sidebar');
        //         } else {
        //             sidebar.classList.remove('fixed-sidebar');
        //         }
        //     }

        //     window.addEventListener('scroll', handleSidebarPosition);
        //     window.addEventListener('resize', handleSidebarPosition);
        // });

        // Save order button handler
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const saveBtnElement = e.target.closest('#save-sidebar-order');
                if (saveBtnElement) {
                    e.preventDefault();
                    console.log('💾 Save button clicked');
                    if (typeof window.saveSidebarOrderFromSettings === 'function') {
                        window.saveSidebarOrderFromSettings();
                    } else {
                        alert('الدالة غير متاحة حالياً');
                        console.error('saveSidebarOrderFromSettings is not defined');
                    }
                }

                // Reset order button handler
                const resetBtnElement = e.target.closest('#reset-sidebar-order');
                if (resetBtnElement) {
                    e.preventDefault();
                    console.log('🔄 Reset button clicked');
                    if (typeof window.resetSidebarOrder === 'function') {
                        window.resetSidebarOrder();
                    } else {
                        alert('الدالة غير متاحة حالياً');
                        console.error('resetSidebarOrder is not defined');
                    }
                }
            });
        });

        // Toggle Sections - Save State to LocalStorage
        document.addEventListener('DOMContentLoaded', function() {
            const STORAGE_KEY = 'settingsSectionsState';

            // Load saved state from localStorage
            function loadSectionsState() {
                const saved = localStorage.getItem(STORAGE_KEY);
                return saved ? JSON.parse(saved) : {};
            }

            // Save state to localStorage
            function saveSectionState(sectionId, isOpen) {
                const state = loadSectionsState();
                state[sectionId] = isOpen;
                localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
            }

            // Toggle section visibility
            function toggleSection(icon, targetId, targetElement) {
                const isCurrentlyClosed = targetElement.style.display == 'none' || getComputedStyle(targetElement).display == 'none';

                // Update display
                targetElement.style.display = isCurrentlyClosed ? 'block' : 'none';

                // Update icon rotation
                icon.style.transform = isCurrentlyClosed ? 'rotate(180deg)' : 'rotate(0deg)';

                // Update parent classes
                icon.parentElement.classList.toggle('mb-6');
                icon.parentElement.classList.toggle('pb-3');
                icon.parentElement.classList.toggle('border-b-2');

                // Update icon classes
                if (isCurrentlyClosed) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }

                // Save state
                saveSectionState(targetId, isCurrentlyClosed);
            }

            // Apply saved states on page load
            const savedState = loadSectionsState();
            Object.entries(savedState).forEach(([sectionId, isOpen]) => {
                const targetElement = document.getElementById(sectionId);
                const toggleIcon = document.querySelector(`[data-section="${sectionId}"]`);

                if (targetElement && toggleIcon) {
                    targetElement.style.display = isOpen ? 'block' : 'none';
                    toggleIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';

                    // Apply parent classes
                    if (isOpen) {
                        toggleIcon.parentElement.classList.add('mb-6');
                        toggleIcon.parentElement.classList.add('pb-3');
                        toggleIcon.parentElement.classList.add('border-b-2');
                    } else {
                        toggleIcon.parentElement.classList.remove('mb-6');
                        toggleIcon.parentElement.classList.remove('pb-3');
                        toggleIcon.parentElement.classList.remove('border-b-2');
                    }

                    if (isOpen) {
                        toggleIcon.classList.remove('fa-chevron-down');
                        toggleIcon.classList.add('fa-chevron-up');
                    } else {
                        toggleIcon.classList.remove('fa-chevron-up');
                        toggleIcon.classList.add('fa-chevron-down');
                    }
                }
            });

            // Add click listeners
            let toggleIcons = document.querySelectorAll('.toggle-icon');
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-section');
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        toggleSection(this, targetId, targetElement);
                    }
                });
            });
        });


        // Live Header Color Preview
        document.addEventListener('DOMContentLoaded', function() {
            const headerColorInput = document.getElementById('header-color');
            const headerTextColorInput = document.getElementById('header-text-color');
            const headerElement = document.getElementById('topbar') || document.querySelector('.topbar');

            if (headerElement && headerColorInput) {
                headerColorInput.addEventListener('input', function() {
                    const selectedColor = this.value;
                    document.documentElement.style.setProperty('--header-color', selectedColor);
                    headerElement.style.cssText = `position: fixed; width: calc(100% - var(--sidebar-width)); left: var(--sidebar-width);`;
                });
            }

            if (headerElement && headerTextColorInput) {
                headerTextColorInput.addEventListener('input', function() {
                    const selectedColor = this.value;
                    document.documentElement.style.setProperty('--header-text-color', selectedColor);
                    headerElement.style.cssText = `position: fixed; width: calc(100% - var(--sidebar-width)); left: var(--sidebar-width);`;
                });
            }
        });

        // Sidebar Navigation & Smooth Scroll
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.settings-nav-item');
            const contentSections = document.querySelectorAll('.bg-gray-50.rounded-lg.p-4');

            // Smooth scroll to section when clicking nav item
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all items
                    navItems.forEach(nav => nav.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Get the section to scroll to
                    const section = this.getAttribute('data-section');
                    let target = null;

                    // Map section to content
                    if (section == 'general') {
                        target = contentSections[0]; // General Settings
                    } else if (section == 'debug-mode') {
                        target = contentSections[1]; // Debug Mode
                    } else if (section == 'debug-ips') {
                        target = contentSections[2]; // Debug IPs
                    } else if (section == 'about-us') {
                        target = contentSections[3]; // About Us
                    } else if (section == 'website-design') {
                        target = contentSections[4]; // Website Design
                    } else if (section == 'colors-website') {
                        target = contentSections[5]; // Colors Website
                    } else if (section == 'colors-dashboard') {
                        target = contentSections[6]; // Colors Dashboard
                    } else if (section == 'fonts') {
                        target = contentSections[7]; // Fonts
                    } else if (section == 'inline-padding') {
                        target = contentSections[8]; // Inline Padding
                    }

                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Highlight active section on scroll
            window.addEventListener('scroll', () => {
                let current = '';

                contentSections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 200) {
                        current = section;
                    }
                });

                navItems.forEach(nav => {
                    nav.classList.remove('active');
                });

                // Find matching nav item based on position
                if (current) {
                    const position = Array.from(contentSections).indexOf(current);
                    if (navItems[position]) {
                        navItems[position].classList.add('active');
                    }
                }
            });
        });

        // Live color preview
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard colors
            const dashboardColors = {
                'dash_primary_color': '--dash_primary_color',
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

        // Database Backups Management
        document.addEventListener('DOMContentLoaded', function() {
            const createBtn = document.getElementById('create-backup-btn');
            const backupsList = document.getElementById('backups-list');
            const statusDiv = document.getElementById('backup-status');

            // Load backups list
            function loadBackups() {
                fetch("{{ route('dashboard.backups.list') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.backups.length > 0) {
                            backupsList.innerHTML = data.backups.map(backup => `
                                <div class="flex items-center justify-between bg-gray-100 p-4 rounded-lg hover:bg-gray-150 transition">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-700">
                                            <i class="fas fa-file-archive text-orange-500"></i>
                                            ${backup.filename}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-calendar"></i> ${new Date(backup.created_at).toLocaleString('ar-EG')} | 
                                            <i class="fas fa-database"></i> ${formatBytes(backup.size)}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="cursor-pointer download-backup px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition" data-filename="${backup.filename}" title="{{ __('main.settings_download') }}">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="cursor-pointer restore-backup px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition" data-filename="${backup.filename}" title="{{ __('main.settings_restore') }}">
                                            <i class="fas fa-redo-alt"></i>
                                        </button>
                                        <button class="cursor-pointer delete-backup px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition" data-filename="${backup.filename}" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            `).join('');

                            // Attach event listeners
                            attachBackupListeners();
                        } else {
                            backupsList.innerHTML = '<p class="text-center text-gray-500 py-8">{{ __('main.settings_no_backups') }}</p>';
                        }
                    })
                    .catch(err => console.error('Error loading backups:', err));
            }

            // Create backup
            createBtn.addEventListener('click', function() {
                if (confirm('{{ __('main.settings_create_backup_confirm') }}')) {
                    createBtn.disabled = true;
                    statusDiv.classList.remove('hidden');
                    statusDiv.innerHTML = '<div class="text-blue-600"><i class="fas fa-spinner fa-spin"></i> {{ __('main.settings_creating_backup') }}</div>';

                    fetch("{{ route('dashboard.backups.create') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                statusDiv.innerHTML = '<div class="text-green-600"><i class="fas fa-check-circle"></i> {{ __('main.settings_backup_created_success') }}</div>';
                                loadBackups();
                            } else {
                                statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> {{ __('main.settings_error_prefix') }}: ' + data.message +
                                    '</div>';
                            }
                            createBtn.disabled = false;
                            setTimeout(() => statusDiv.classList.add('hidden'), 4000);
                        })
                        .catch(err => {
                            statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> {{ __('main.settings_connection_error') }}</div>';
                            createBtn.disabled = false;
                            setTimeout(() => statusDiv.classList.add('hidden'), 4000);
                        });
                }
            });

            // Attach listeners for backup actions
            function attachBackupListeners() {
                document.querySelectorAll('.download-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        window.location.href = "{{ url('dashboard/backups/download') }}/" + filename;
                    });
                });

                document.querySelectorAll('.restore-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        if (confirm('{{ __('main.settings_restore_confirm') }}')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('dashboard.backups.restore') }}";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="filename" value="${filename}">
                            `;
                            document.body.appendChild(form);

                            // Show loading message
                            alert('{{ __('main.settings_restore_in_progress') }}');
                            form.submit();
                        }
                    });
                });

                document.querySelectorAll('.delete-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        if (confirm('{{ __('main.settings_delete_backup_confirm') }}')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('dashboard.backups.delete') }}";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="filename" value="${filename}">
                                <input type="hidden" name="_method" value="DELETE">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // Helper function to format bytes
            function formatBytes(bytes) {
                if (bytes === 0) return '0 {{ __('main.bytes') }}';
                const k = 1024;
                const sizes = ['{{ __('main.bytes') }}', '{{ __('main.kb') }}', '{{ __('main.mb') }}', '{{ __('main.gb') }}'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Load backups on page load
            loadBackups();
        });
    </script>
@endpush
