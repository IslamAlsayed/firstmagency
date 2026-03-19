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
    <div class="background rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-5 border-custom-b-1">
            <h5 class="text-2xl font-semibold text-blue-900">
                <i class="fas fa-cog"></i>
                {{ __('main.settings_management') }}
            </h5>
        </div>

        <!-- Main Grid: Sidebar + Content -->
        {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 p-4"> --}}
        <div class="grid grid-cols-1 gap-6 p-4">
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
                            <span class="text-sm font-semibold text-gray-700">Debug IPs</span>
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
                        <a href="#section-fonts" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                            data-section="fonts">
                            <i class="fas fa-font text-purple-500 group-hover:scale-110 transition"></i>
                            <span class="text-sm font-semibold text-gray-700">{{ __('main.font_settings') }}</span>
                        </a>

                        <!-- Inline Padding -->
                        <a href="#section-inline-padding" class="settings-nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-200 transition-all duration-300 cursor-pointer group"
                            data-section="inline-padding">
                            <i class="fas fa-arrows-alt-h text-purple-500 group-hover:scale-110 transition"></i>
                            <span class="text-sm font-semibold text-gray-700">Padding</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Settings Content -->
            {{-- <div class="lg:col-span-3 space-y-6"> --}}
            <div class="space-y-6">
                <!-- General Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
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

                        <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Debug Mode Toggle -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-bug text-red-500"></i>
                            {{ __('main.debug_mode') }}
                        </div>

                        <div class="toggle-icon" toggle-button data-section="debug-mode-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <form action="{{ route('dashboard.settings.toggleDebugMode') }}" method="POST" class="space-y-5" id="debug-mode-section">
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
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-network-wired text-blue-500"></i>
                            {{ __('main.debug_mode_allowed_ips') }}
                        </div>

                        <div class="toggle-icon" toggle-button data-section="debug-ips-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <form action="{{ route('dashboard.settings.updateDebugIps') }}" method="POST" class="space-y-5" id="debug-ips-section">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-3">
                                <strong>Your Current IP:</strong> <span class="font-mono bg-blue-100 px-3 py-1 rounded text-blue-700">{{ getCurrentClientIp() }}</span>
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
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary font-semibold rounded-[9px] shadow-md">
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

                        {{-- About Us Image 2 --}}
                        @include('dashboard.components.photo', ['record' => $settings, 'column' => 'about_us_image2'])

                        <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Website Design Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
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
                                            placeholder="Website Design Title" value="{{ $settings->website_design_title ?? '' }}">
                                    </div>

                                    {{-- Website Design Heading EN --}}
                                    <div>
                                        <label for="website-design-heading" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                        <input type="text" id="website-design-heading" name="website_design_heading"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="Website Design Heading" value="{{ $settings->website_design_heading ?? '' }}">
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
                                            placeholder="عنوان تصميم المواقع" value="{{ $settings->website_design_title_ar ?? '' }}">
                                    </div>

                                    {{-- Website Design Heading AR --}}
                                    <div>
                                        <label for="website-design-heading-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                        <input type="text" id="website-design-heading-ar" name="website_design_heading_ar"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="عنوان تصميم المواقع" value="{{ $settings->website_design_heading_ar ?? '' }}">
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
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Colors Website -->
                <div class="bg-gray-50 rounded-lg p-4">
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
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Colors Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
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
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Fonts Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
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
                            Save Changes
                        </button>
                    </form>
                </div>

                {{-- @include('dashboard.sections.debug-table') --}}

                <!-- Inline Padding Sections Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div class="w-full flex items-center justify-between gap-4">
                            <div>
                                <i class="fas fa-palette text-blue-500"></i>
                                {{ __('main.inline_padding_sections_settings') }}
                            </div>

                            <input type="text" id="inline-padding-search" placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.sections')]) }}"
                                class="w-[280px] px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm">
                        </div>

                        <div class="toggle-icon" toggle-button data-section="inline-padding-toggle-sections">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <form action="{{ route('dashboard.settings.updateInlinePadding') }}" method="POST" class="space-y-5" id="inline-padding-toggle-sections">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-lowercase" id="inline-padding-sections">
                            {{-- Home Page Inline Padding Settings --}}
                            <div class="inline-padding-section" data-section="flag-hero">
                                <label for="home-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-hero</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-hero-section" name="home_hero_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="120" value="{{ $settings->home_hero_section ?? '200' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-services">
                                <label for="home-services-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-services</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-services-section" name="home_services_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->home_services_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-projects">
                                <label for="home-projects-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-projects</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-projects-section" name="home_projects_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="20" value="{{ $settings->home_projects_section ?? '20' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-reviews">
                                <label for="home-reviews-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-reviews</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-reviews-section" name="home_reviews_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->home_reviews_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-clients">
                                <label for="home-clients-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-clients</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="home-clients-section" name="home_clients_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="120" value="{{ $settings->home_clients_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-about-us">
                                <label for="about-us-steps" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-about-us</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-steps" name="about_us_line_works_steps_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_line_works_steps_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-partners">
                                <label for="about-us-partners" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-partners</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-partners" name="about_us_partners_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_partners_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-line-works">
                                <label for="line-works-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-line-works</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="line-works-section" name="work_lines_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->work_lines_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-portfolio">
                                <label for="portfolio-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-portfolio</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="portfolio-section" name="portfolio_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->portfolio_section ?? '200' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-articles">
                                <label for="blog-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-articles</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="blog-articles-section" name="blog_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->blog_articles_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-articles-page">
                                <label for="articles-page-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-articles-page</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="articles-page-section" name="articles_page_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="200" value="{{ $settings->articles_page_section ?? '200' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-contact">
                                <label for="contact-page" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-contact</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="contact-page" name="contact_page_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->contact_page_section ?? '180' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-website-developer">
                                <label for="website-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-website-developer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-developer-section" name="website_developer_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_developer_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-programming">
                                <label for="website-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-programming</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-programming-section" name="website_programming_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_programming_section ?? '200' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-website-designer">
                                <label for="website-design-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-website-designer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-design-section" name="website_design_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_design_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-important-articles">
                                <label for="website-important-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-important-articles</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="website-important-articles-section" name="website_important_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->website_important_articles_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-faq">
                                <label for="faqs-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-faq</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="faqs-section" name="faqs_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->faqs_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-app-developer-hero">
                                <label for="app-developer-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-app-developer-hero</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="app-developer-hero-section" name="app_developer_hero_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="240" value="{{ $settings->app_developer_hero_section ?? '240' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-app-important-articles">
                                <label for="app-important-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-app-important-articles</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="app-important-articles-section" name="app_important_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="100" value="{{ $settings->app_important_articles_section ?? '100' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-projects-steps">
                                <label for="projects-steps-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-projects-steps</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="projects-steps-section" name="projects_steps_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->projects_steps_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-app-developer">
                                <label for="app-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-app-developer</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="app-developer-section" name="feature_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="200" value="{{ $settings->feature_section ?? '200' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-packages">
                                <label for="packages-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-packages</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="packages-section" name="packages_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="120" value="{{ $settings->packages_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-operating-systems">
                                <label for="operations-systems-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-operating-systems</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="operations-systems-section" name="operations_systems_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->operations_systems_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-your-domain">
                                <label for="your-domain-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-your-domain</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="your-domain-section" name="your_domain_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->your_domain_section ?? '240' }}">
                            </div>

                            <div class="inline-padding-section" data-section="flag-pest-domains">
                                <label for="pest-domains-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-pest-domains</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="pest-domains-section" name="pest_domains_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->pest_domains_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-why-us">
                                <label for="why-us-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-why-us</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="why-us-section" name="why_us_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->why_us_section ?? '120' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-platform-management">
                                <label for="platform-management-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-platform-management</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="platform-management-section" name="platform_management_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->platform_management_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-packages-marketing">
                                <label for="packages-marketing-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-packages-marketing</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="packages-marketing-section" name="packages_marketing_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->packages_marketing_section ?? '120' }}">
                            </div>

                            <div class="inline-padding-section" data-section="flag-order-app">
                                <label for="order-app-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-order-app</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="order-app-section" name="order_your_app_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="170" value="{{ $settings->order_your_app_section ?? '170' }}">
                            </div>


                            <div class="inline-padding-section" data-section="flag-categories-programming">
                                <label for="categories-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-categories-programming</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="categories-programming-section" name="categories_programming_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->categories_programming_section ?? '60' }}">
                            </div>
                            <div class="inline-padding-section" data-section="flag-dont-worry-hosting">
                                <label for="dont-worry-hosting-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-dont-worry-hosting</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="dont-worry-hosting-section" name="dont_worry_hosting_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->dont_worry_hosting_section ?? '60' }}">
                            </div>








                        </div>
                        <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Sidebar Reordering Section -->
                {{-- <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-bars text-blue-500"></i>
                            ترتيب الـ Sidebar
                        </div>

                        <div class="toggle-icon" toggle-button data-section="sidebar-reordering-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <div id="sidebar-reordering-section" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Editing Area -->
                        <div class="space-y-4">
                            <h6 class="text-lg font-bold text-gray-700 mb-4">
                                <i class="fas fa-edit text-blue-600"></i> اسحب وأفلت لتعديل الترتيب
                            </h6>
                            <div id="settingsSidebarMenu" class="bg-white rounded-lg shadow-md p-4 space-y-3 max-h-96 overflow-y-auto">
                                @include('dashboard.layout.partials.sidebar-sortable-menu')
                            </div>
                            <div class="flex gap-2">
                                <button id="save-sidebar-order" type="button" class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                                    <i class="fas fa-save"></i> حفظ الترتيب
                                </button>
                                <button id="reset-sidebar-order" type="button" class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                                    <i class="fas fa-redo"></i> إعادة تعيين
                                </button>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div class="space-y-4">
                            <h6 class="text-lg font-bold text-gray-700 mb-4">
                                <i class="fas fa-eye text-purple-600"></i> معاينة الترتيب النهائي
                            </h6>
                            <div id="previewSidebarMenu" class="bg-white rounded-lg shadow-md p-4 space-y-3 max-h-96 overflow-y-auto">
                                @include('dashboard.layout.partials.sidebar-preview-menu')
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Database Backups Section -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-database text-blue-500"></i>
                            قاعدة البيانات - Backup & Restore
                        </div>

                        <div class="toggle-icon" toggle-button data-section="database-backups-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <div id="database-backups-section" class="space-y-6">
                        <!-- Create Backup -->
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h5 class="text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-plus-circle text-green-500"></i> إنشاء نسخة احتياطية جديدة
                            </h5>
                            <button id="create-backup-btn" class="flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                                <i class="fas fa-download"></i> عمل Backup الآن
                            </button>
                            <div id="backup-status" class="mt-3 hidden"></div>
                        </div>

                        <!-- Backups List -->
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h5 class="text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-list text-blue-500"></i> النسخ الاحتياطية المتاحة
                            </h5>
                            <div id="backups-list" class="space-y-3 max-h-96 overflow-y-auto">
                                <div class="text-center py-8">
                                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                                    <p class="text-gray-500 mt-2">جاري التحميل...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Backup Info -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <h5 class="font-semibold text-blue-900 mb-2">
                                <i class="fas fa-info-circle"></i> معلومات مهمة
                            </h5>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>✓ يتم حفظ النسخ في مجلد آمن في الخادم</li>
                                <li>✓ يمكنك استرجاع أي نسخة قديمة في أي وقت</li>
                                <li>✓ يمكنك تحميل النسخة الاحتياطية على جهازك</li>
                                <li>⚠️ استرجاع النسخة سيستبدل البيانات الحالية</li>
                            </ul>
                        </div>
                    </div>
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

            // Initialize sidebar ordering
            setTimeout(() => {
                if (typeof window.initSettingsSidebarOrderer === 'function') {
                    console.log('🎯 Initializing sidebar reordering...');
                    window.initSettingsSidebarOrderer();
                } else {
                    console.warn('⚠️ Sidebar ordering functions not loaded yet - retrying...');
                    // Retry after another delay
                    setTimeout(() => {
                        if (typeof window.initSettingsSidebarOrderer === 'function') {
                            window.initSettingsSidebarOrderer();
                        }
                    }, 1000);
                }
            }, 1000);

            // Save order button handler
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
                                        <button class="cursor-pointer download-backup px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition" data-filename="${backup.filename}" title="تحميل">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="cursor-pointer restore-backup px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition" data-filename="${backup.filename}" title="استرجاع">
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
                            backupsList.innerHTML = '<p class="text-center text-gray-500 py-8">لا توجد نسخ احتياطية</p>';
                        }
                    })
                    .catch(err => console.error('Error loading backups:', err));
            }

            // Create backup
            createBtn.addEventListener('click', function() {
                if (confirm('هل تريد عمل نسخة احتياطية الآن؟')) {
                    createBtn.disabled = true;
                    statusDiv.classList.remove('hidden');
                    statusDiv.innerHTML = '<div class="text-blue-600"><i class="fas fa-spinner fa-spin"></i> جاري إنشاء النسخة الاحتياطية...</div>';

                    fetch("{{ route('dashboard.backups.create') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                statusDiv.innerHTML = '<div class="text-green-600"><i class="fas fa-check-circle"></i> تم إنشاء النسخة الاحتياطية بنجاح</div>';
                                loadBackups();
                            } else {
                                statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> خطأ: ' + data.message + '</div>';
                            }
                            createBtn.disabled = false;
                            setTimeout(() => statusDiv.classList.add('hidden'), 4000);
                        })
                        .catch(err => {
                            statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> خطأ في الاتصال</div>';
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
                        if (confirm('⚠️ تحذير: هذا سيستبدل جميع البيانات الحالية. هل تريد المتابعة؟')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('dashboard.backups.restore') }}";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="filename" value="${filename}">
                            `;
                            document.body.appendChild(form);

                            // Show loading message
                            alert('⏳ جاري استرجاع النسخة الاحتياطية... يرجى الانتظار (قد يستغرق وقتاً طويلاً)');
                            form.submit();
                        }
                    });
                });

                document.querySelectorAll('.delete-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        if (confirm('هل أنت متأكد من حذف هذه النسخة؟')) {
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
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Load backups on page load
            loadBackups();
        });
    </script>
@endpush
