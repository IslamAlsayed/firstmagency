<section class="section services-section text-center relative">
    <div class="title font-semibold">{{ __('main.services_title') }} <span class="title-badge">{{ __('main.services_subtitle') }}</span></div>
    <div class="description">{{ __('main.services_description') }}</div>

    <div class="our-services-wrapper">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="15" slides-per-view="5"
            breakpoints='{"320": {"slidesPerView": 1, "spaceBetween": 10}, "640": {"slidesPerView": 2, "spaceBetween": 15}, "1024": {"slidesPerView": 3, "spaceBetween": 15}, "1400": {"slidesPerView": 5, "spaceBetween": 15}}'>
            @if (config('main-services') && count(config('main-services')) > 0)
                @foreach (config('main-services') as $service)
                    <swiper-slide class="service-item">
                        <a href="" class="service-image">
                            <img src="{{ asset('assets/images/website/services/' . $service['image']) }}" alt="{{ __('main.' . $service['title_key']) }}">
                        </a>
                        <div class="service-text">
                            <div class="icon">
                                <img src="{{ asset('assets/images/website/services/' . $service['icon']) }}" alt="{{ __('main.' . $service['title_key']) }}">
                            </div>
                            <div class="service-title font-semibold">{{ __('main.' . $service['title_key']) }}</div>
                            <div class="service-description">{{ __('main.' . $service['desc_key']) }}</div>
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
            @endif
        </swiper-container>
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-services</div>
    @endif
</section>
