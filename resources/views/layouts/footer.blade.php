<footer class="">
    <div class="layer"></div>
    <div class="inner">
        <div class="footer-header flex items-center justify-between gap-4">
            <div class="description">
                {{ __('main.footer_description') }}
            </div>

            <div class="social">
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </button>
                <button class="btn-link main-color dark-hover font-semibold">
                    <a href="#" target="_blank">
                        <i class="fab fa-telegram"></i>
                    </a>
                </button>
            </div>
        </div>

        <div class="footer-body flex items-end justify-between gap-4">
            <div class="child">
                <div class="title font-semibold">{{ __('main.footer_offer_new') }}</div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="image">
                        <img src="{{ asset('assets/images/google-map.png') }}" alt="">
                    </div>
                    <div class="text">
                        <div class="title font-semibold">{{ __('main.footer_egypt') }}</div>
                        <div class="label">{{ __('main.footer_egypt_address') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="image">
                        <img src="{{ asset('assets/images/google-line.png') }}" alt="">
                    </div>
                    <div class="text">
                        <div class="title font-semibold">{{ __('main.footer_uae') }}</div>
                        <div class="label">{{ __('main.footer_uae_address') }}</div>
                    </div>
                </div>
            </div>
            <div class="child">
                <div class="title font-semibold">{{ __('main.footer_important_links') }}</div>
                <ul>
                    <li><a href="#"><i class="icon fas fa-home"></i>{{ __('main.footer_home_page') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-info-circle"></i>{{ __('main.footer_about_company') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-briefcase"></i>{{ __('main.footer_our_portfolio') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-newspaper"></i>{{ __('main.footer_articles_news') }}</a></li>
                </ul>
            </div>
            <div class="child">
                <ul>
                    <li><a href="#"><i class="icon fas fa-code"></i>{{ __('main.footer_website_design') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-bullhorn"></i>{{ __('main.footer_digital_marketing') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-mobile-alt"></i>{{ __('main.footer_mobile_apps') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-palette"></i>{{ __('main.footer_brand_design') }}</a></li>
                </ul>
            </div>
            <div class="child">
                <ul>
                    <li><a href="#"><i class="icon fas fa-user-plus"></i>{{ __('main.footer_register_account') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-envelope"></i>{{ __('main.footer_contact_us_form') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-shield-alt"></i>{{ __('main.footer_privacy_policy') }}</a></li>
                    <li><a href="#"><i class="icon fas fa-file-contract"></i>{{ __('main.footer_terms_conditions') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-footer flex items-center justify-between gap-4">
            <div class="description">
                {{ __('main.footer_copyright') }}
            </div>
            <div class="payments">
                <img src="{{ asset('assets/images/payments.png') }}" alt="Payments Methods">
            </div>
        </div>
    </div>
</footer>
