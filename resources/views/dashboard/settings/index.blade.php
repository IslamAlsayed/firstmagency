@extends('dashboard.layout.master')

@section('title', __('main.settings'))
@section('page-title', '⚡ ' . __('main.settings'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
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

        .settings-tab-btn {
            padding: 10px 16px;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            background: white;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;

            &.active {
                background-color: var(--button_color);
                color: var(--text_color);
                border-color: var(--button_color);
            }

            &:hover:not(.active) {
                border-color: var(--button_color);
            }
        }

        .settings-content {
            display: none;

            &.active {
                display: block;
            }
        }
    </style>
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #8b5cf6;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-sliders-h"></i>
                        {{ __('main.settings') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.settings') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.general_settings') }}</p>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-cog',
                    'items' => [['id' => 'stat-sections', 'value' => 4, 'label' => __('main.general_settings')], ['id' => 'stat-colors', 'value' => 7, 'label' => __('main.color_dashboard')]],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-sliders-h',
                'title' => __('main.general_settings'),
                'description' => __('main.settings'),
            ])

            <div class="entity-toolbar">
                <div class="flex gap-2 flex-wrap content-start">
                    <button type="button" class="settings-tab-btn active" data-tab="general">
                        <i class="fas fa-cog"></i> {{ __('main.general_settings') }}
                    </button>
                    <button type="button" class="settings-tab-btn" data-tab="colors">
                        <i class="fas fa-palette"></i> {{ __('main.color_dashboard') }}
                    </button>
                    <button type="button" class="settings-tab-btn" data-tab="design">
                        <i class="fas fa-font"></i> {{ __('main.font_settings') }}
                    </button>
                </div>
            </div>

            <div class="entity-content">
                <!-- TAB: General Settings -->
                <div class="settings-content active" data-tab="general">
                    <div class="mt-4">
                        <form action="{{ route('dashboard.settings.updateGeneral') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.site_email') }}</label>
                                    <input type="email" name="site_email" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->site_email ?? 'info@firstmagency.com' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.site_whatsapp') }}</label>
                                    <input type="tel" name="site_whatsapp" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->site_whatsapp ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.site_phone') }}</label>
                                    <input type="tel" name="site_phone" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->site_phone ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.width_logo_sidebar') }}</label>
                                    <input type="number" name="width_logo_sidebar" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->width_logo_sidebar ?? 70 }}">
                                </div>
                            </div>

                            <div class="col-span-full">
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'site_description',
                                    'value' => $settings->site_description,
                                    'classes' => 'mb-4',
                                    'height' => '300px',
                                ])

                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'site_description_ar',
                                    'value' => $settings->site_description_ar,
                                    'height' => '300px',
                                ])
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.ably_key') }}</label>
                                <input type="text" name="ably_key" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                    value="{{ $settings->ably_key ?? '' }}">
                                <span class="text-xs text-gray-500">{{ __('main.ably_key_desc', ['default' => config('app.ably_key')]) }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.cache_time') }} ({{ __('main.seconds') }})</label>
                                <input type="number" name="cache_time" min="60" step="60"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                    value="{{ $settings->cache_time ?? config('app.cache_time') }}">
                                <span class="text-xs text-gray-500">{{ __('main.cache_time_desc', ['default' => config('app.cache_time')]) }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.button_display_mode') }}</label>
                                <select name="button_display_mode" class="kt-select basic-single" data-kt-select="true">
                                    <option value="text" {{ getActiveUser()->button_display_mode == 'text' ? 'selected' : '' }}>{{ __('main.text') }}</option>
                                    <option value="icon" {{ getActiveUser()->button_display_mode == 'icon' ? 'selected' : '' }}>{{ __('main.icon') }}</option>
                                    <option value="both" {{ getActiveUser()->button_display_mode == 'both' ? 'selected' : '' }}>{{ __('main.both') }}</option>
                                </select>
                            </div>

                            <button type="submit" class="flex items-center gap-2 px-6 py-3 font-semibold radius-lg transition" style="color: var(--text_color); background-color: var(--button_color);">
                                <i class="fas fa-save"></i> {{ __('main.settings_save_changes') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- TAB: Colors -->
                <div class="settings-content" data-tab="colors">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Website Colors -->
                        <div class="bg-white radius-lg shadow-lg p-6 space-y-5">
                            <h6 class="text-lg font-semibold text-gray-700 pb-3 border-b-2 border-blue-300">
                                <i class="fas fa-palette text-blue-500"></i> {{ __('main.color_website') }}
                            </h6>

                            <form action="{{ route('dashboard.settings.updateColorsWebsite') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.main_color') }}</label>
                                    <input type="color" name="main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300" value="{{ $settings->main_color ?? '#d05423' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.dark_main_color') }}</label>
                                    <input type="color" name="dark_main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->dark_main_color ?? '#96310E' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.light_main_color') }}</label>
                                    <input type="color" name="light_main_color" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->light_main_color ?? '#F97316' }}">
                                </div>

                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 font-semibold radius-lg transition"
                                    style="color: var(--text_color); background-color: var(--button_color);">
                                    <i class="fas fa-save"></i> {{ __('main.settings_save_changes') }}
                                </button>
                            </form>
                        </div>

                        <!-- Dashboard Colors -->
                        <div class="bg-white radius-lg shadow-lg p-6 space-y-5">
                            <h6 class="text-lg font-semibold text-gray-700 pb-3 border-b-2 border-purple-300">
                                <i class="fas fa-palette text-purple-500"></i> {{ __('main.color_dashboard') }}
                            </h6>

                            <form action="{{ route('dashboard.settings.updateColors') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.primary_color') }}</label>
                                    <input type="color" name="colors[dash_primary_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->colors['dash_primary_color'] ?? '#F54900' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.text_color') }}</label>
                                    <input type="color" name="colors[text_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->colors['text_color'] ?? '#ffffff' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.button_color') }}</label>
                                    <input type="color" name="colors[button_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->colors['button_color'] ?? '#0074F7' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.icon_color') }}</label>
                                    <input type="color" name="colors[icon_color]" class="w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300"
                                        value="{{ $settings->colors['icon_color'] ?? '#4a5565' }}">
                                </div>

                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 font-semibold radius-lg transition"
                                    style="color: var(--text_color); background-color: var(--button_color);">
                                    <i class="fas fa-save"></i> {{ __('main.settings_save_changes') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- TAB: Design (Fonts) -->
                <div class="settings-content" data-tab="design">
                    <div>
                        <h6 class="text-lg font-semibold text-gray-700 my-4 pb-3 border-b-2 border-purple-300">
                            <i class="fas fa-font text-purple-500"></i> {{ __('main.font_settings') }}
                        </h6>

                        <form action="{{ route('dashboard.settings.updateFonts') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.font_name') }}</label>
                                    <input type="text" name="font_name" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->font_name ?? 'Tajawal' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.font_url') }}</label>
                                    <input type="url" name="font_url" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500"
                                        value="{{ $settings->font_url ?? '' }}">
                                </div>
                            </div>

                            <button type="submit" class="flex items-center gap-2 px-6 py-3 font-semibold radius-lg transition" style="color: var(--text_color); background-color: var(--button_color);">
                                <i class="fas fa-save"></i> {{ __('main.settings_save_changes') }}
                            </button>
                        </form>
                    </div>

                    @if (userSidebarPreference())
                        <div class="mt-6 bg-amber-50 border-l-4 border-amber-500 radius-lg shadow-lg p-6">
                            <h6 class="text-lg font-semibold text-amber-900 mb-3">
                                <i class="fas fa-info-circle"></i> {{ __('main.settings') }}
                            </h6>

                            <form action="{{ route('dashboard.sidebar.reset') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg transition">
                                    <i class="fas fa-redo"></i> {{ __('main.reset_sort_sidebar_menu') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --dash_primary_color: {{ $settings->colors['dash_primary_color'] ?? '#F54900' }};
            --text_color: {{ $settings->colors['text_color'] ?? '#ffffff' }};
            --icon_color: {{ $settings->colors['icon_color'] ?? '#4a5565' }};
            --button_color: {{ $settings->colors['button_color'] ?? '#0074F7' }};
            --main-color: {{ $settings->main_color ?? '#d05423' }};
            --dark-main-color: {{ $settings->dark_main_color ?? '#96310E' }};
            --light-main-color: {{ $settings->light_main_color ?? '#F97316' }};
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.settings-tab-btn');
            const tabContents = document.querySelectorAll('.settings-content');

            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabName = this.dataset.tab;

                    // Remove active class from all buttons and contents
                    tabButtons.forEach(b => b.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    document.querySelector(`[data-tab="${tabName}"].settings-content`).classList.add('active');
                });
            });
        });
    </script>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initCkEditors() {
                if (window.CKEDITOR) {
                    document.querySelectorAll('textarea.ckeditor').forEach(function(el) {
                        if (el.id && CKEDITOR.instances[el.id]) {
                            CKEDITOR.instances[el.id].destroy(true);
                        }
                        if (!el.classList.contains('ckeditor-initialized')) {
                            CKEDITOR.replace(el.id, {
                                height: 300
                            });
                            el.classList.add('ckeditor-initialized');
                        }
                    });
                } else {
                    setTimeout(initCkEditors, 300);
                }
            }
            initCkEditors();
        });
    </script>
@endpush
