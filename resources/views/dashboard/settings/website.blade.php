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
        </div>
    </div>
@endsection
