<section class="section programming-section feature-section text-center relative" id="hosting-features">
    <div class="title font-semibold">{{ __('main.hosting_features_title') }} <span class="title-badge">{{ __('main.brand_name') }}</span></div>
    <div class="description">{{ __('main.hosting_features_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @php
            $featuresList = isset($features) && count($features) > 0 ? $features : config('features-hosting') ?? [];
        @endphp
        @if ($featuresList && count($featuresList) > 0)
            @foreach ($featuresList as $feature)
                <div class="website">
                    <div class="image cursor-pointer">
                        @if ($feature instanceof \App\Models\FeaturesHosting)
                            @if ($feature->image)
                                <img src="{{ Storage::url($feature->image) }}" alt="{{ $feature->translations[app()->getLocale()]['title'] ?? '' }}">
                            @else
                                <img src="{{ asset('assets/images/website/placeholder.png') }}"
                                    alt="{{ $feature->translations[app()->getLocale()]['title'] ?? '' }}">
                            @endif
                        @else
                            <img src="{{ asset('assets/images/website/' . $feature['image']) }}" alt="{{ __('main.' . $feature['title_key']) }}">
                        @endif
                    </div>
                    <div class="title font-semibold">
                        @if ($feature instanceof \App\Models\FeaturesHosting)
                            {{ $feature->translations[app()->getLocale()]['title'] ?? $feature->slug }}
                        @else
                            {{ __('main.' . $feature['title_key']) }}
                        @endif
                    </div>
                    <div class="description">
                        @if ($feature instanceof \App\Models\FeaturesHosting)
                            {{ $feature->translations[app()->getLocale()]['description'] ?? '' }}
                        @else
                            {{ __('main.' . $feature['description_key']) }}
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-hosting-features</div>
    @endif
</section>
