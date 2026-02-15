<div class="about-section flex items-center justify-center">
    <div class="text">
        <div class="title font-semibold">{{ __('main.about_title') }}</div>
        <div class="description">
            {{ __('main.about_description') }}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="#contact">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="image">
        <img src="{{ asset('assets/images/about/main-image.png') }}" alt="About Us Image" loading="lazy">
    </div>
</div>
