<div class="section partners-section text-center">
    <div class="title font-semibold">{{ __('main.partners_title') }} <span class="title-badge">{{ __('main.brand_short') }}</span></div>
    <div class="description">{{ __('main.partners_description') }}</div>

    <div class="our-partners-wrapper">
        @for ($i = 1; $i <= 6; $i++)
            <div class="partner">
                <a href="#">
                    <img src="{{ asset('assets/images/partners/' . $i . '.png') }}" alt="{{ __('main.partners_item') }} {{ $i }}">
                </a>
            </div>
        @endfor
    </div>
</div>
