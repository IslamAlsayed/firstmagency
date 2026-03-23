<section class="about-section flex items-center relative justify-center">
    <div class="text">
        <div class="title font-semibold">
            {{ app()->getLocale() == 'en' ? $settings->about_us_title : $settings->about_us_title_ar ?? __('main.about_us_title') }}
        </div>
        <div class="description">
            {!! app()->getLocale() == 'en' ? $settings->about_us_description : $settings->about_us_description_ar ?? __('main.about_us_description') !!}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="{{ route('tickets.index') }}">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="image">
        <img src="{{ asset('assets/' . $settings->about_us_image2) }}" alt="{{ app()->getLocale() == 'en' ? $settings->about_us_title : $settings->about_us_title_ar }}" loading="lazy">
    </div>

    {{-- @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-about-us</div>
    @endif --}}
</section>
