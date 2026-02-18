<div class="header flex items-center justify-between py-4" id="header">
    <div class="inner">
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
            <div class="header-side flex items-center justify-between gap-4">
                <div class="info flex items-center gap-2">
                    <div class="pseudo-element-info"></div>
                    <div class="">
                        <p class="font-semibold">فرست للبرمجة والتسويق</p>
                        <span>القائمة</span>
                    </div>
                </div>
                <div class="close">
                    <i class="fas fa-xmark"></i>
                </div>
            </div>

            <div class="contact-actions flex items-center gap-4">
                <button>
                    <a href="https://apicontact-actions.whatsapp.com/send/?phone=201212601601&text&type=phone_number&app_absent=0"
                        class="flex items-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        واتساب
                    </a>
                </button>
                <button>
                    <a href="https://apicontact-actions.whatsapp.com/send/?phone=201212601601&text&type=phone_number&app_absent=0"
                        class="flex items-center gap-2">
                        <i class="fa-solid fa-phone fa-flip"></i>
                        اتصل الان
                    </a>
                </button>
            </div>

            <ul class="list-navbar flex gap-4">
                <li class="flex items-center">
                    <a href="/"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ $currentRoute == 'home' || $currentRoute == '' ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.home') }}</span>
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('about-us') }}"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ $currentRoute == 'about-us' ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.about_us') }}</span>
                    </a>
                </li>
                <li class="flex items-center our_services">
                    <div
                        class="nav-link btn-link flex items-center justify-between font-semibold gap-2 hover {{ $currentRoute == 'our_works' ? 'active' : '' }}">
                        <div class="flex items-center gap-2">
                            <div class="pseudo-element"></div>
                            <span>{{ __('main.our_services') }}</span>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="services">
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>برمجة وتصميم المواقع</span>
                        </a>
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>برمجة تطبيقات الموبيل</span>
                        </a>
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>خدمات الاستضافة</span>
                        </a>
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>حجز دومين</span>
                        </a>
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>التسويق الالكتـــروني</span>
                        </a>
                        <a href="#" class="service-link">
                            <div class="pseudo-element"></div>
                            <span>خدمات السيـــــــو</span>
                        </a>
                    </div>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('portfolio') }}"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ $currentRoute == 'portfolio' ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.our_works') }}</span>
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('blog') }}"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ $currentRoute == 'blog' || Str::contains($currentRoute, 'blog') ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.articles') }}</span>
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="https://client.firstmagency.com"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ request()->url() == 'https://client.firstmagency.com' ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.clients') }}</span>
                    </a>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('contact') }}"
                        class="nav-link btn-link flex items-center gap-2 font-semibold hover {{ $currentRoute == 'contact' ? 'active' : '' }}">
                        <div class="pseudo-element"></div>
                        <span>{{ __('main.contact') }}</span>
                    </a>
                </li>
            </ul>

            <div class="social-links flex items-center justify-center gap-2">
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                </button>
            </div>
        </nav>
        <div class="flex items-center justify-between gap-4">
            <div class="languages language-selector">
                @if (app()->getLocale() == 'ar')
                    <a href="{{ route('locale.change', 'en') }}" class="btn-link font-semibold">
                        <img src="{{ asset('assets/images/flags/en.svg') }}" alt="english language">
                    </a>
                @else
                    <a href="{{ route('locale.change', 'ar') }}" class="btn-link font-semibold">
                        <img src="{{ asset('assets/images/flags/ar.svg') }}" alt="arabic language">
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
