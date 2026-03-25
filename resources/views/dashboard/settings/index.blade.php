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
                        <div>
                            <label for="width_logo_sidebar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.width_logo_sidebar') }}</label>
                            <input type="number" id="width_logo_sidebar" name="width_logo_sidebar"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="{{ __('main.settings_width_logo_sidebar') }}" value="{{ $settings->width_logo_sidebar ?? 70 }}">
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

                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer font-semibold radius-lg shadow-md"
                        style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
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
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer font-semibold radius-lg shadow-md"
                        style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
                    </button>
                </form>
            </div>

            <!-- Colors Settings -->
            <div class="bg-white radius-lg shadow-lg p-6">
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
                            <label for="dash_primary_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.main_color') }}</label>
                            <input type="color" id="dash_primary_color" name="colors[dash_primary_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->colors['dash_primary_color'] ?? '#0074F7' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="text_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.text_color') }}</label>
                            <input type="color" id="text_color" name="colors[text_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->colors['text_color'] ?? '#ffffff' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="icon_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.icon_color') }}</label>
                            <input type="color" id="icon_color" name="colors[icon_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->colors['icon_color'] ?? '#4a5565' }}">
                        </div>
                        <div class="flex-1 text-nowrap" style="min-width: 100px; max-width: 200px;">
                            <label for="button_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.button_color') }}</label>
                            <input type="color" id="button_color" name="colors[button_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                                value="{{ $settings->colors['button_color'] ?? '#0074F7' }}">
                        </div>
                    </div>
                    {{-- <div class="flex items-center flex-wrap gap-4">
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
                    </div> --}}
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white font-semibold radius-lg shadow-md"
                        style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
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
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer font-semibold radius-lg shadow-md"
                        style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
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
            --dash_primary_color: {{ $settings->colors['dash_primary_color'] ?? '#fff' }};
            --text_color: {{ $settings->colors['text_color'] ?? '#6c757d' }};
            --icon_color: {{ $settings->colors['icon_color'] ?? '#198754' }};
            --button_color: {{ $settings->colors['button_color'] ?? '#dc3545' }};

            --main-color: {{ $settings->colors['main_color'] ?? '#d05423' }};
            --dark-main-color: {{ $settings->colors['dark_main_color'] ?? '#96310E' }};
            --light-main-color: {{ $settings->colors['light_main_color'] ?? '#F97316' }};
        }

        /* Live preview styles */
        [style*="--dash_primary_color"] {
            color: var(--dash_primary_color);
        }

        [style*="--text_color"] {
            color: var(--text_color);
        }

        [style*="--icon_color"] {
            color: var(--icon_color);
        }

        [style*="--button_color"] {
            color: var(--button_color);
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
        // Live color preview
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard colors
            const dashboardColors = {
                'dash_primary_color': '--dash_primary_color',
                'text_color': '--text_color',
                'icon_color': '--icon_color',
                'button_color': '--button_color',
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

        // Live styles
        document.addEventListener('DOMContentLoaded', function() {
            const width_logo_sidebar = document.getElementById("width_logo_sidebar");
            if (width_logo_sidebar) {
                width_logo_sidebar.addEventListener('input', function(e) {
                    document.documentElement.style.setProperty('--width_logo_sidebar', e.target.value + 'px');
                });
            }
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
    </script>
@endpush
