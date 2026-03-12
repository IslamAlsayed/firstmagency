<section class="section services-section text-center relative">
    <div class="title font-semibold">{{ __('main.services_title') }} <span class="title-badge">{{ __('main.services_subtitle') }}</span></div>
    <div class="description">{{ __('main.services_description') }}</div>
    <div class="our-services-wrapper">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="15" slides-per-view="5"
            breakpoints='{"320": {"slidesPerView": 1, "spaceBetween": 10}, "640": {"slidesPerView": 2, "spaceBetween": 15}, "1024": {"slidesPerView": 3, "spaceBetween": 15}, "1400": {"slidesPerView": 5, "spaceBetween": 15}}'>
            @if ($services && count($services) > 0)
                @foreach ($services as $service)
                    <swiper-slide class="service-item">
                        <a href="" class="service-image">
                            <img src="{{ asset('storage/' . ($service->image ?? ($service['image'] ?? ''))) }}"
                                alt="{{ $service->slug ?? ($service['slug'] ?? '') }}" loading="lazy">
                        </a>
                        <div class="service-text">
                            <div class="icon">
                                <img src="{{ asset('storage/' . ($service->icon ?? ($service['icon'] ?? ''))) }}"
                                    alt="{{ $service->slug ?? ($service['slug'] ?? '') }}" loading="lazy">
                            </div>
                            @php
                                $locale = app()->getLocale();
                                if (is_object($service)) {
                                    $title = $service->translations[$locale]['title'] ?? ($service->slug ?? '');
                                    $description = $service->translations[$locale]['description'] ?? '';
                                } else {
                                    $title = $service['translations'][$locale]['title'] ?? ($service['slug'] ?? '');
                                    $description = $service['translations'][$locale]['description'] ?? '';
                                }
                            @endphp
                            <div class="service-title font-semibold">{{ $title }}</div>
                            <div class="service-description">{{ $description }}</div>
                        </div>
                        <div class="service-action">
                            <button class="btn-link main-color font-semibold">
                                <a href="{{ route('services.marketing') }}">
                                    {{ __('main.request_now') }}
                                    <i class="icon fa-solid fa-square-arrow-up-right"></i>
                                </a>
                            </button>
                        </div>
                    </swiper-slide>
                @endforeach
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">{{ __('main.no_items_found') }}</p>
                </div>
            @endif
        </swiper-container>
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-services</div>
    @endif
</section>
