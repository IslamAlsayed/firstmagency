<section class="about-section flex items-center justify-center relative">
    <div class="text">
        <div class="title font-semibold">{{ app()->getLocale() == 'en' ? $settings->about_us_title : $settings->about_us_title_ar }}</div>
        <div class="description">
            {!! app()->getLocale() == 'en' ? $settings->about_us_description : $settings->about_us_description_ar !!}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="{{ route('tickets.index') }}">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="image">
        <img src="{{ asset($settings->about_us_image) }}" alt="{{ app()->getLocale() == 'en' ? $settings->about_us_title : $settings->about_us_title_ar }}"
            loading="lazy">
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-about-us</div>
    @endif
</section>
