<div class="hero-section flex items-center justify-between gap-4">
    <div class="text">
        <div class="title font-semibold">{{ __('main.hero_title') }} <span class="title-badge">{{ __('main.hero_badge') }}</span></div>
        <div class="description">
            {{ __('main.hero_description') }}
        </div>
        <button class="btn-link main-color dark-hover font-semibold">
            <a href="{{ route('contact') }}">{{ __('main.contact_button') }}</a>
        </button>
    </div>
    <div class="gallery">
        <div class="swapper">
            @for ($i = 1; $i <= 4; $i++)
                <div class="item {{ $i === 1 ? 'active' : '' }}">
                    <img src="{{ asset('assets/images/hero/' . $i . '.png') }}" alt="Hero Image {{ $i }}">
                </div>
            @endfor
        </div>
        <div class="gallery-dots">
            @for ($i = 0; $i < 4; $i++)
                <button class="dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></button>
            @endfor
        </div>
    </div>
</div>
