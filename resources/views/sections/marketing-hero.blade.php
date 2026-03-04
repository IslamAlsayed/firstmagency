<section class="developer-section app-developer-section marketing-hero relative">
    <div class="inner flex items-center gap-4">
        <div class="content">
            <div class="text">
                <h1 class="font-semibold">{{ __('main.marketing_company_header') }}</h1>
                <div class="description">{{ __('main.marketing_description') }}</div>
            </div>
            <div class="tags">
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_ads_managed') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_followers') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_page_verification') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_attractive_designs') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_professional_content') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_targeting_100') }}
                </div>
            </div>
        </div>
        <div class="image magnetic-effect">
            <img src="{{ asset('assets/images/website/services-marketing/hero-1.png') }}" alt="{{ __('main.ecommerce_programming') }}">
        </div>
    </div>
    <div class="inner hidden flex items-center gap-4">
        <div class="content">
            <div class="text">
                <h1 class="font-semibold">{{ __('main.marketing_services_title') }}</h1>
                <div class="description">{{ __('main.marketing_services_description') }}</div>
            </div>
            <div class="tags">
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.content_strategy_monthly') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.professional_responses') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.performance_reports') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.full_account_management') }}
                </div>
                <div class="tag flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    {{ __('main.marketing_strategy') }}
                </div>
            </div>
        </div>
        <div class="image last-image magnetic-effect">
            <img src="{{ asset('assets/images/website/services-marketing/hero-2.png') }}" alt="{{ __('main.website_design_company') }}">
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-marketing-hero</div>
    @endif
</section>
