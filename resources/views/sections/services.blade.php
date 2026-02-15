<div class="container section services-section text-center">
    <div class="title font-semibold">{{ __('main.services_title') }} <span class="title-badge">{{ __('main.services_subtitle') }}</span></div>
    <div class="description">{{ __('main.services_description') }}</div>

    @php
        $services = [
            [
                'image' => '1.jpg',
                'icon' => 'icon-1.png',
                'title_key' => 'service_domain_reservation_title',
                'desc_key' => 'service_domain_reservation_desc',
            ],
            [
                'image' => '2.jpg',
                'icon' => 'icon-2.png',
                'title_key' => 'service_digital_marketing_title',
                'desc_key' => 'service_digital_marketing_desc',
            ],
            [
                'image' => '3.jpg',
                'icon' => 'icon-3.png',
                'title_key' => 'service_mobile_apps_title',
                'desc_key' => 'service_mobile_apps_desc',
            ],
            [
                'image' => '4.jpg',
                'icon' => 'icon-4.png',
                'title_key' => 'service_hosting_services_title',
                'desc_key' => 'service_hosting_services_desc',
            ],
            [
                'image' => '5.jpg',
                'icon' => 'icon-5.png',
                'title_key' => 'service_website_design_title',
                'desc_key' => 'service_website_design_desc',
            ],
        ];
    @endphp

    <div class="our-services-wrapper">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="15" slides-per-view="5"
            breakpoints='{"320": {"slidesPerView": 1, "spaceBetween": 10}, "640": {"slidesPerView": 2, "spaceBetween": 15}, "1024": {"slidesPerView": 3, "spaceBetween": 15}, "1400": {"slidesPerView": 5, "spaceBetween": 15}}'>
            @foreach ($services as $service)
                <swiper-slide class="service-item">
                    <div class="service-image">
                        <img src="{{ asset('assets/images/services/' . $service['image']) }}" alt="{{ __('main.' . $service['title_key']) }}">
                    </div>
                    <div class="service-text">
                        <div class="icon">
                            <img src="{{ asset('assets/images/services/' . $service['icon']) }}" alt="{{ __('main.' . $service['title_key']) }}">
                        </div>
                        <div class="service-title font-semibold">{{ __('main.' . $service['title_key']) }}</div>
                        <div class="service-description">{{ __('main.' . $service['desc_key']) }}</div>
                    </div>
                    <div class="service-action">
                        <button class="btn-link main-color font-semibold">
                            <a href="#contact">
                                {{ __('main.request_now') }}
                                <i class="icon fa-solid fa-square-arrow-up-right"></i>
                            </a>
                        </button>
                    </div>
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>
</div>
