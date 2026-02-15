<div class="header flex items-center justify-between py-4" id="header">
    <div class="container inner">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.png.webp') }}" alt="{{ __('main.brand_name') }} Logo">
            </a>
        </div>
        <nav class="navbar" id="navbar">
            <ul class="flex gap-4">
                <li><a href="#services" class="btn-link font-semibold hover">{{ __('main.home') }}</a></li>
                <li><a href="#about" class="btn-link font-semibold hover">{{ __('main.about_us') }}</a></li>
                <li><a href="#portfolio" class="btn-link font-semibold hover">{{ __('main.portfolio') }}</a></li>
                <li><a href="#articles" class="btn-link font-semibold hover">{{ __('main.articles') }}</a></li>
                <li><a href="#clients" class="btn-link font-semibold hover">{{ __('main.clients') }}</a></li>
                <li><a href="#contact" class="btn-link font-semibold hover">{{ __('main.contact') }}</a></li>
            </ul>
        </nav>
        <div class="flex items-center justify-between gap-4">
            <div class="language-selector" style="display: flex; gap: 8px;">
                @if (app()->getLocale() == 'ar')
                    <a href="{{ route('locale.change', 'en') }}" class="btn-link font-semibold">
                        EN
                    </a>
                @else
                    <a href="{{ route('locale.change', 'ar') }}" class="btn-link font-semibold">
                        AR
                    </a>
                @endif
            </div>
            <div class="btn-link main-color font-semibold">
                <a href="#contact" class="whatsapp-link">
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

<script>
    let lastScrollTop = 0;
    const header = document.getElementById('header');

    window.addEventListener('scroll', () => {
        let currentScroll = window.scrollY || document.documentElement.scrollTop;

        // اختفي الـ header عند التمرير للأسفل، ظهور عند التمرير للأعلى
        if (currentScroll > lastScrollTop && currentScroll > 100) {
            // Scroll Down - اخفي الـ header
            header.classList.add('active');
        } else {
            // Scroll Up - اظهر الـ header
            header.classList.remove('active');
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });
</script>
