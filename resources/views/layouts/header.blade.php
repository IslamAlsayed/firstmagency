<div class="header flex items-center justify-between py-4" id="header">
    <div class="container inner">
        <div class="logo">
            <a href="{{ url('/') }}" class="shineEffect">
                <img src="{{ asset('assets/images/logo.png.webp') }}" alt="{{ __('main.brand_name') }} Logo">
            </a>

            <div class="contact-fast">
                <div class="contact-area">
                    <div class="heading font-semibold">فرست ماركيتنج للبرمجة والتسويق</div>
                    <div class="childs flex flex-col gap-6">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text flex items-center gap-4">
                                <div class="icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span class="font-semibold">موبايل</span>
                            </div>
                            <div class="contact">01212601601</div>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="text flex items-center gap-4">
                                <div class="icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span class="font-semibold">الشركة</span>
                            </div>
                            <div class="contact">01212602602</div>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="text flex items-center gap-4">
                                <div class="icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span class="font-semibold">البريد</span>
                            </div>
                            <div class="contact">info@firstmagency.com</div>
                        </div>
                    </div>
                </div>
                <div class="social">
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    </button>
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </button>
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#" target="_blank"><i class="fab fa-x-twitter"></i></a>
                    </button>
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    </button>
                </div>
            </div>
        </div>

        @php
            $currentRoute = Route::currentRouteName();
        @endphp

        <nav class="navbar" id="navbar" data-set="{{ $currentRoute }}" data-set2="{{ request()->url() }}">
            <ul class="flex gap-4">
                <li class="flex items-center">
                    <a href="/" class="btn-link font-semibold hover {{ $currentRoute == 'home' || $currentRoute == '' ? 'active' : '' }}">
                        {{ __('main.home') }}
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('about-us') }}" class="btn-link font-semibold hover {{ $currentRoute == 'about-us' ? 'active' : '' }}">
                        {{ __('main.about_us') }}
                    </a>
                </li>
                <li class="flex items-center our_services">
                    <div class="btn-link hover {{ $currentRoute == 'our_works' ? 'active' : '' }}">
                        <span class="font-semibold">{{ __('main.our_services') }}</span>
                        <i class="fas fa-chevron-down"></i>

                        <div class="services">
                            <a href="#" class="service-link">برمجة وتصميم المواقع</a>
                            <a href="#" class="service-link">برمجة تطبيقات الموبيل</a>
                            <a href="#" class="service-link">خدمات الاستضافة</a>
                            <a href="#" class="service-link">حجز دومين</a>
                            <a href="#" class="service-link">التسويق الالكتـــروني</a>
                            <a href="#" class="service-link">خدمات السيـــــــو</a>
                        </div>
                    </div>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('portfolio') }}" class="btn-link font-semibold hover {{ $currentRoute == 'portfolio' ? 'active' : '' }}">
                        {{ __('main.our_works') }}
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('blog') }}"
                        class="btn-link font-semibold hover {{ $currentRoute == 'blog' || Str::contains($currentRoute, 'blog') ? 'active' : '' }}">
                        {{ __('main.articles') }}
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="https://client.firstmagency.com"
                        class="btn-link font-semibold hover {{ request()->url() == 'https://client.firstmagency.com' ? 'active' : '' }}">
                        {{ __('main.clients') }}
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('contact') }}" class="btn-link font-semibold hover {{ $currentRoute == 'contact' ? 'active' : '' }}">
                        {{ __('main.contact') }}
                    </a>
                </li>
            </ul>
        </nav>
        <div class="flex items-center justify-between gap-4">
            <div class="language-selector" style="display: flex; gap: 8px;">
                @if (app()->getLocale() == 'ar')
                    <a href="{{ route('locale.change', 'en') }}" class="btn-link font-semibold">
                        <img src="{{ asset('assets/images/flags/ar.svg') }}" alt="arabic language">
                    </a>
                @else
                    <a href="{{ route('locale.change', 'ar') }}" class="btn-link font-semibold">
                        <img src="{{ asset('assets/images/flags/en.svg') }}" alt="english language">
                    </a>
                @endif
            </div>
            <div class="btn-link main-color font-semibold whatsapp">
                <a href="https://api.whatsapp.com/send/?phone=201212601601&text&type=phone_number&app_absent=0" class="whatsapp-link">
                    <span>{{ __('main.whatsapp_contact') }}</span>
                    <i class="icon fab fa-whatsapp"></i>
                </a>
            </div>
            <div class="menu" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>
</div>
