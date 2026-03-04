<section class="about-section flex items-center relative justify-center">
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
        <img src="{{ asset('assets/images/website/about/text-bg.png') }}" alt="{{ __('main.about_us_image') }}" loading="lazy">
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-about-us</div>
    @endif
</section>

{{-- <section class="about-section flex items-center justify-center">
    <div class="text">
        <div class="title font-semibold">{{ $settings->about_us_title ?? __('main.about_title') }}</div>
        <div class="description">
            {{ $settings->about_us_description ?? __('main.about_description') }}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="{{ route('contact') }}">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="image">
        @if ($settings->about_us_image && checkExistFile($settings->about_us_image))
            <img src="{{ asset('storage/' . $settings->about_us_image) }}" alt="{{ __('main.about_us_image') }}" loading="lazy">
        @else
            <img src="{{ asset('assets/images/website/about/text-bg.png') }}" alt="{{ __('main.about_us_image') }}" loading="lazy">
        @endif
    </div>
</section> --}}
