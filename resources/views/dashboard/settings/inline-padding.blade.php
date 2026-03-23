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

        <!-- Main Grid: Sidebar + Content -->
        <div class="grid grid-cols-1 gap-6 p-4">
            <!-- Sidebar Navigation -->
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
                </h6>

                <form action="{{ route('dashboard.settings.inline-padding.update') }}" method="POST" class="space-y-5" id="inline-padding-toggle-sections">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-lowercase" id="inline-padding-sections">
                        {{-- Home Page Inline Padding Settings --}}
                        <div class="inline-padding-section" data-section="flag-hero">
                            <label for="home-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-hero</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="home-hero-section" name="sections_padding[home_hero_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['home_hero_section'] ?? '200' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-services">
                            <label for="home-services-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-services</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="home-services-section" name="sections_padding[home_services_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['home_services_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-projects">
                            <label for="home-projects-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-projects</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="home-projects-section" name="sections_padding[home_projects_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="20" value="{{ $settings->sections_padding['home_projects_section'] ?? '20' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-reviews">
                            <label for="home-reviews-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-reviews</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="home-reviews-section" name="sections_padding[home_reviews_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['home_reviews_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-clients">
                            <label for="home-clients-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-clients</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="home-clients-section" name="sections_padding[home_clients_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['home_clients_section'] ?? '120' }}">
                        </div>
                        {{-- 
                            <div class="inline-padding-section" data-section="flag-about-us">
                                <label for="about-us-steps" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                    <span>flag-about-us</span>
                                    <span>(px)</span>
                                </label>
                                <input type="number" minLength="1" id="about-us-steps" name="sections_padding[about_us_line_works_steps_section]"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="60" value="{{ $settings->sections_padding['about_us_line_works_steps_section'] ?? '60' }}">
                            </div> --}}
                        <div class="inline-padding-section" data-section="flag-partners">
                            <label for="about-us-partners" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-partners</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="about-us-partners" name="sections_padding[about_us_partners_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['about_us_partners_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-line-works">
                            <label for="line-works-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-line-works</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="line-works-section" name="sections_padding[work_lines_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['work_lines_section'] ?? '120' }}">
                        </div>

                        <div class="inline-padding-section" data-section="flag-portfolio">
                            <label for="portfolio-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-portfolio</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="portfolio-section" name="sections_padding[portfolio_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['portfolio_section'] ?? '200' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-articles">
                            <label for="blog-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-articles</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="blog-articles-section" name="sections_padding[blog_articles_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['blog_articles_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-articles-page">
                            <label for="articles-page-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-articles-page</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="articles-page-section" name="sections_padding[articles_page_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['articles_page_section'] ?? '200' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-contact">
                            <label for="contact-page" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-contact</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="contact-page" name="sections_padding[contact_page_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="180" value="{{ $settings->sections_padding['contact_page_section'] ?? '180' }}">
                        </div>

                        <div class="inline-padding-section" data-section="flag-website-developer">
                            <label for="website-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-website-developer</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="website-developer-section" name="sections_padding[website_developer_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['website_developer_section'] ?? '120' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-programming">
                            <label for="website-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-programming</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="website-programming-section" name="sections_padding[website_programming_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['website_programming_section'] ?? '200' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-website-designer">
                            <label for="website-design-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-website-designer</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="website-design-section" name="sections_padding[website_design_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['website_design_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-important-articles">
                            <label for="website-important-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-important-articles</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="website-important-articles-section" name="sections_padding[website_important_articles_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['website_important_articles_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-faq">
                            <label for="faqs-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-faq</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="faqs-section" name="sections_padding[faqs_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['faqs_section'] ?? '60' }}">
                        </div>

                        <div class="inline-padding-section" data-section="flag-app-developer-hero">
                            <label for="app-developer-hero-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-app-developer-hero</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="app-developer-hero-section" name="sections_padding[app_developer_hero_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="240" value="{{ $settings->sections_padding['app_developer_hero_section'] ?? '240' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-app-important-articles">
                            <label for="app-important-articles-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-app-important-articles</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="app-important-articles-section" name="sections_padding[app_important_articles_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="100" value="{{ $settings->sections_padding['app_important_articles_section'] ?? '100' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-projects-steps">
                            <label for="projects-steps-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-projects-steps</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="projects-steps-section" name="sections_padding[projects_steps_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['projects_steps_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-app-developer">
                            <label for="app-developer-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-app-developer</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="app-developer-section" name="sections_padding[feature_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['feature_section'] ?? '200' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-packages">
                            <label for="packages-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-packages</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="packages-section" name="sections_padding[packages_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['packages_section'] ?? '120' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-operating-systems">
                            <label for="operations-systems-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-operating-systems</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="operations-systems-section" name="sections_padding[operations_systems_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['operations_systems_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-your-domain">
                            <label for="your-domain-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-your-domain</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="your-domain-section" name="sections_padding[your_domain_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="240" value="{{ $settings->sections_padding['your_domain_section'] ?? '240' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-pest-domains">
                            <label for="pest-domains-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-pest-domains</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="pest-domains-section" name="sections_padding[pest_domains_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['pest_domains_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-why-us">
                            <label for="why-us-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-why-us</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="why-us-section" name="sections_padding[why_us_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['why_us_section'] ?? '120' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-platform-management">
                            <label for="platform-management-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-platform-management</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="platform-management-section" name="sections_padding[platform_management_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['platform_management_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-packages-marketing">
                            <label for="packages-marketing-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-packages-marketing</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="packages-marketing-section" name="sections_padding[packages_marketing_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="120" value="{{ $settings->sections_padding['packages_marketing_section'] ?? '120' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-dont-worry-hosting">
                            <label for="dont-worry-hosting-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-dont-worry-hosting</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="dont-worry-hosting-section" name="sections_padding[dont_worry_hosting_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="60" value="{{ $settings->sections_padding['dont_worry_hosting_section'] ?? '60' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-order-app">
                            <label for="order-app-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-order-app</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="order-app-section" name="sections_padding[order_your_app_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="170" value="{{ $settings->sections_padding['order_your_app_section'] ?? '170' }}">
                        </div>
                        <div class="inline-padding-section" data-section="flag-categories-programming">
                            <label for="categories-programming-section" class="flex items-center justify-between gap-2 text-sm font-semibold text-primary mb-1" style="font-size: 12px">
                                <span>flag-categories-programming</span>
                                <span>(px)</span>
                            </label>
                            <input type="number" minLength="1" id="categories-programming-section" name="sections_padding[categories_programming_section]"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                placeholder="200" value="{{ $settings->sections_padding['categories_programming_section'] ?? '200' }}">
                        </div>
                    </div>
                    <button type="submit" toggle-button class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                        <i class="fas fa-save"></i>
                        {{ __('main.settings_save_changes') }}
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
                </h6>

                <form action="{{ route('dashboard.settings.toggleDebugMode') }}" method="POST" class="space-y-5" id="debug-mode-section">
                    @csrf
                    <p class="text-sm text-gray-500">
                        {{ __('main.settings_debug_mode_note') }}
                    </p>
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 cursor-pointer {{ $settings->debug_mode ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-semibold rounded-[9px] shadow-md">
                        <i class="fas {{ $settings->debug_mode ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                        {{ $settings->debug_mode ? __('main.settings_disable_debug_mode') : __('main.settings_enable_debug_mode') }}
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
                </h6>

                <form action="{{ route('dashboard.settings.updateDebugIps') }}" method="POST" class="space-y-5" id="debug-ips-section">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-3">
                            <strong>{{ __('main.settings_current_ip_label') }}:</strong> <span class="font-mono bg-blue-100 px-3 py-1 rounded text-blue-700">{{ getCurrentClientIp() }}</span>
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ __('main.settings_debug_ips_empty_note') }}
                        </p>
                    </div>

                    <div>
                        <label for="debug-ips" class="block text-sm font-semibold text-gray-600 mb-2">{{ __('main.settings_allowed_ips_per_line') }}</label>
                        <textarea id="debug-ips" name="debug_ips"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm font-mono text-sm"
                            rows="4" placeholder="127.0.0.1&#10;192.168.1.100">{{ $settings->debug_ips ? implode("\n", json_decode($settings->debug_ips, true)) : '' }}</textarea>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>{{ __('main.settings_quick_add') }}:</strong> {{ __('main.settings_add_current_ip_note') }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            {{ __('main.settings_save_ips') }}
                        </button>
                        <button type="button" id="add-my-ip-btn"
                            class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-green-600 hover:bg-green-700 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-plus"></i>
                            {{ __('main.settings_add_my_ip') }}
                        </button>
                    </div>
                </form>

                <!-- Hidden form for Add My IP -->
                <form id="add-my-ip-form" action="{{ route('dashboard.settings.addMyIpToDebug') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Inline Padding Sections Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('inline-padding-search');
            const sections = document.querySelectorAll('.inline-padding-section');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase().trim();
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
        });
    </script>
@endpush
