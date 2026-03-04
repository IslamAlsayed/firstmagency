<title>@yield('title', 'First Magency')</title>
<base href="../../">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta content="Sign in page" name="description" />
<meta content="@firstmagency" name="twitter:site" />
<meta content="@firstmagency" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="Metronic" name="twitter:title" />
<meta content="Sign in page" name="twitter:description" />

<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="en_US" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="@firstmagency" property="og:site_name" />
<meta content="First Magency" property="og:title" />
<meta content="Sign in page" property="og:description" />

{{-- Google Fonts + Cairo for bolder weights --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800&family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet"> --}}

<link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}"
    rel="stylesheet">

{{-- ? Start plugins --}}
{{-- Select multiple plugin --}}
<link href="{{ asset('assets/plugins/select2@4.1.0-rc.0/css/select2.min.css') }}" rel="stylesheet" />
{{-- Fontawesome icons pro --}}
<link href="{{ asset('assets/plugins/fontawesome-icons/css/all.min.css') }}" rel="stylesheet" />
{{-- Swiper slider --}}
<link href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" rel="stylesheet" />
<!-- Tailwind CSS -->
<link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
{{-- ? End plugins --}}

{{-- Toasts Styles --}}
<link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
{{-- Toasts Scripts --}}
<script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>

{{-- custom css --}}
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

{{-- sections css --}}
<link href="{{ asset('assets/css/pages/homePage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/aboutPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/contactPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/workPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/websiteDeveloperPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/appDeveloperPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/projectStepsPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/hostingPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/domainsPage.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/pages/servicesMarketingPage.css') }}" rel="stylesheet" />

<style>
    :root {
        --main-color: {{ $settings->main_color ?? '#d05423' }};
        --dark-main-color: {{ $settings->dark_main_color ?? '#96310E' }};
        --light-main-color: {{ $settings->light_main_color ?? '#F97316' }};

        --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;

        --home-hero-section-inline-padding: {{ $settings->home_hero_section ?? 120 }}px;
        --home-services-section-inline-padding: {{ $settings->home_services_section ?? 60 }}px;
        --home-projects-section-inline-padding: {{ $settings->home_projects_section ?? 20 }}px;
        --home-reviews-section-inline-padding: {{ $settings->home_reviews_section ?? 60 }}px;
        --home-clients-section-inline-padding: {{ $settings->home_clients_section ?? 120 }}px;

        --about-us-line-works-steps-section-inline-padding: {{ $settings->about_us_line_works_steps_section ?? 60 }}px;
        --about-us-partners-section-inline-padding: {{ $settings->about_us_partners_section ?? 60 }}px;

        --portfolio-section-inline-padding: {{ $settings->portfolio_section ?? 60 }}px;
        --blog-articles-section-inline-padding: {{ $settings->blog_articles_section ?? 60 }}px;
        --contact-page-section-inline-padding: {{ $settings->contact_page_section ?? 180 }}px;

        --website-developer-section-inline-padding: {{ $settings->website_developer_section ?? 60 }}px;
        --website-programming-section-inline-padding: {{ $settings->website_programming_section ?? 60 }}px;
        --website-design-section-inline-padding: {{ $settings->website_design_section ?? 60 }}px;
        --website-important-articles-section-inline-padding: {{ $settings->website_important_articles_section ?? 60 }}px;
        --faqs-section-inline-padding: {{ $settings->faqs_section ?? 60 }}px;

        --app-important-articles-section-inline-padding: {{ $settings->app_important_articles_section ?? 120 }}px;
        --feature-section-inline-padding: {{ $settings->feature_section ?? 60 }}px;
        --packages-section-inline-padding: {{ $settings->packages_section ?? 120 }}px;
        --operations-systems-section-inline-padding: {{ $settings->operations_systems_section ?? 60 }}px;
        --your-domain-section-inline-padding: {{ $settings->your_domain_section ?? 240 }}px;
        --pest-domains-section-inline-padding: {{ $settings->pest_domains_section ?? 60 }}px;
        --why-us-section-inline-padding: {{ $settings->why_us_section ?? 120 }}px;
        --platform-management-section-inline-padding: {{ $settings->platform_management_section ?? 60 }}px;
        --work-lines-section-inline-padding: {{ $settings->work_lines_section ?? 120 }}px;
        --our-services-marketing-section-inline-padding: {{ $settings->our_services_marketing_section ?? 120 }}px;
    }
</style>
