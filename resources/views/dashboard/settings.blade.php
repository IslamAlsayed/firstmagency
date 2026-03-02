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
                            <label for="site-locale" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.site_locale') }}</label>
                            <input type="text" id="site-locale" name="site_locale"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="ar" value="{{ $settings->site_locale ?? 'ar' }}">
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

                <!-- Inline Padding Sections Settings -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <i class="fas fa-arrows-alt-h text-purple-500"></i>
                        Inline Padding Sections Settings
                    </h6>
                    <form action="{{ route('dashboard.settings.updateInlinePadding') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        {{-- Home Page Inline Padding Settings --}}
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.home_page') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div>
                                        <label for="home-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                            <span>Home Hero Section (px)</span>
                                            {{-- <span class="text-red-600">flag-{{ rand(513, 6846) }}</span> --}}
                                        </label>
                                        <input type="number" minLength="1" id="home-hero-section" name="home_hero_section"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="120" value="{{ $settings->home_hero_section ?? '120' }}">
                                    </div>
                                    <div>
                                        <label for="home-services-section"
                                            class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                            <span>Home Services Section (px)</span>
                                            {{-- <span class="text-red-600">flag-{{ rand(513, 6846) }}</span> --}}
                                        </label>
                                        <input type="number" minLength="1" id="home-services-section" name="home_services_section"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="60" value="{{ $settings->home_services_section ?? '60' }}">
                                    </div>
                                    <div>
                                        <label for="home-projects-section"
                                            class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                            <span>Home Projects Section (px)</span>
                                            {{-- <span class="text-red-600">flag-{{ rand(513, 6846) }}</span> --}}
                                        </label>
                                        <input type="number" minLength="1" id="home-projects-section" name="home_projects_section"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="20" value="{{ $settings->home_projects_section ?? '20' }}">
                                    </div>
                                    <div>
                                        <label for="home-reviews-section"
                                            class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                            <span>Home Reviews Section (px)</span>
                                            {{-- <span class="text-red-600">flag-{{ rand(513, 6846) }}</span> --}}
                                        </label>
                                        <input type="number" minLength="1" id="home-reviews-section" name="home_reviews_section"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="60" value="{{ $settings->home_reviews_section ?? '60' }}">
                                    </div>
                                    <div>
                                        <label for="home-clients-section"
                                            class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                            <span>Home Clients Section (px)</span>
                                            {{-- <span class="text-red-600">flag-{{ rand(513, 6846) }}</span> --}}
                                        </label>
                                        <input type="number" minLength="1" id="home-clients-section" name="home_clients_section"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="120" value="{{ $settings->home_clients_section ?? '120' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="about-us-steps" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>About Us Steps (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-steps" name="about_us_steps"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_steps_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="about-us-partners" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>About Us Partners (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-partners" name="about_us_partners"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->about_us_partners_section ?? '60' }}">
                            </div>

                            <div>
                                <label for="portfolio-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Portfolio (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="portfolio-section" name="portfolio_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->portfolio_section ?? '60' }}">
                            </div>

                            <div>
                                <label for="blog-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Blog Articles Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="blog-articles-section" name="blog_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->blog_articles_section ?? '60' }}">
                            </div>

                            <div>
                                <label for="contact-page" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Contact Page (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="contact-page" name="contact_page_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->contact_page_section ?? '180' }}">
                            </div>

                            <div>
                                <label for="website-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Website Developer Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="website-developer-section" name="website_developer_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_developer_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="website-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Website Programming Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="website-programming-section" name="website_programming_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_programming_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="website-design-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Website Design Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="website-design-section" name="website_design_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_design_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="website-important-articles-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Website Important Articles Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="website-important-articles-section" name="website_important_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->website_important_articles_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="faqs-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>FAQs Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="faqs-section" name="faqs_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="180" value="{{ $settings->faqs_section ?? '60' }}">
                            </div>

                            <div>
                                <label for="app-important-articles-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>App Important Articles Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="app-important-articles-section" name="app_important_articles_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->app_important_articles_section ?? '120' }}">
                            </div>
                            <div>
                                <label for="feature-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>App Programming Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="feature-section" name="feature_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->feature_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="packages-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Packages Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="packages-section" name="packages_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->packages_section ?? '120' }}">
                            </div>
                            <div>
                                <label for="operations-systems-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Operations Systems Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="operations-systems-section" name="operations_systems_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->operations_systems_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="your-domain-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Your Domain Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="your-domain-section" name="your_domain_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->your_domain_section ?? '240' }}">
                            </div>

                            <div>
                                <label for="pest-domains-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>App Important Articles Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="pest-domains-section" name="pest_domains_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->pest_domains_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="why-us-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Why Us Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="why-us-section" name="why_us_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->why_us_section ?? '120' }}">
                            </div>
                            <div>
                                <label for="platform-management-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Platform Management Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="platform-management-section" name="platform_management_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->platform_management_section ?? '60' }}">
                            </div>
                            <div>
                                <label for="work-lines-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Work Lines Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="work-lines-section" name="work_lines_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->work_lines_section ?? '120' }}">
                            </div>
                            <div>
                                <label for="our-services-marketing-section"
                                    class="flex items-center justify-between gap-2 text-sm font-semibold text-gray-600 mb-1">
                                    <span>Our Services Marketing Section (px)</span>
                                    <span class="text-red-600">flag-{{ rand(513, 6846) }}</span>
                                </label>
                                <input type="number" minLength="1" id="our-services-marketing-section" name="our_services_marketing_section"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->our_services_marketing_section ?? '120' }}">
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
        </script>
    @endpush

@endsection
