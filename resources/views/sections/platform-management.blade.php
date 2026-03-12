<section class="section platform-management-sections text-center relative">
    <div class="mb-8">
        <div class="title text-3xl font-semibold mb-4">
            {{ __('main.platform_management_title') }} <span class="title-badge">{{ __('main.advertising_platforms_badge') }}</span>
        </div>
        <p class="text-gray-600">{{ __('main.platform_management_description') }}</p>
    </div>

    <div class="platform-cards grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $platforms = isset($platforms) && count($platforms) > 0 ? $platforms : config('platform-management') ?? [];
        @endphp

        @forelse ($platforms as $platform)
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ $platform->translations[app()->getLocale()]['title'] ?? '-' }}</h3>
                <p class="platform-desc">{{ limitedText($platform->translations[app()->getLocale()]['description'] ?? '', 100) }}</p>
            </article>
        @empty
            {{-- Fallback to static content if no items in database --}}
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.facebook_platform') }}</h3>
                <p class="platform-desc">{{ __('main.facebook_description') }}</p>
            </article>
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.instagram_platform') }}</h3>
                <p class="platform-desc">{{ __('main.instagram_description') }}</p>
            </article>
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.google_ads_platform') }}</h3>
                <p class="platform-desc">{{ __('main.google_ads_description') }}</p>
            </article>
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.snapchat_ads_platform') }}</h3>
                <p class="platform-desc">{{ __('main.snapchat_ads_description') }}</p>
            </article>
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.tiktok_platform') }}</h3>
                <p class="platform-desc">{{ __('main.tiktok_description') }}</p>
            </article>
            <article class="platform">
                <div class="platform-bg"></div>
                <h3 class="platform-title font-semibold">{{ __('main.seo_platform_service') }}</h3>
                <p class="platform-desc">{{ __('main.seo_description') }}</p>
            </article>
        @endforelse
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-platform-management</div>
    @endif
</section>
