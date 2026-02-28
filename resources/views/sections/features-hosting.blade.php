<section class="section programming-section feature-section text-center">
    <div class="title font-semibold">{{ __('main.hosting_features_title') }} <span class="title-badge">{{ __('main.brand_name') }}</span></div>
    <div class="description">{{ __('main.hosting_features_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @if (config('features-hosting') && count(config('features-hosting')) > 0)
            @foreach (config('features-hosting') as $feature)
                <div class="website">
                    <div class="image cursor-pointer">
                        <img src="{{ asset('assets/images/website/' . $feature['image']) }}" alt="{{ __('main.' . $feature['title_key']) }}">
                    </div>
                    <div class="title font-semibold">{{ __('main.' . $feature['title_key']) }}</div>
                    <div class="description">{{ __('main.' . $feature['description_key']) }}</div>
                </div>
            @endforeach
        @endif
    </div>
</section>
