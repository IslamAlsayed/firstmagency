<section class="about-section flex items-center justify-center relative">
    <div class="text">
        <div class="title font-semibold">{{ __('main.about_title') }}</div>
        <div class="description">
            {{ __('main.about_description') }}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="{{ route('contact') }}">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="image">
        <img src="{{ asset('assets/images/website/about/main-image.png') }}" alt="{{ __('main.about_us_image') }}" loading="lazy">
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-about-us</div>
    @endif
</section>
