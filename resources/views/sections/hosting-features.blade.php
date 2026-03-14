<section class="section programming-section feature-section text-center relative" id="hosting-features">
    <div class="title font-semibold">{{ __('main.hosting_features_title') }} <span class="title-badge">{{ __('main.brand_name') }}</span></div>
    <div class="description">{{ __('main.hosting_features_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @php
            $featuresList = isset($features) && count($features) > 0 ? $features : [];
        @endphp
        @if ($featuresList && count($featuresList) > 0)
            @foreach ($featuresList as $feature)
                <div class="website">
                    <div class="image cursor-pointer">
                        @if ($feature->image && checkExistFile($feature->image))
                            <img src="{{ asset('storage/' . $feature->image) }}" alt="{{ $feature->slug }}">
                        @endif
                    </div>
                    <div class="title font-semibold">{{ $feature->translations[app()->getLocale()]['title'] }}</div>
                    <div class="description">{{ $feature->translations[app()->getLocale()]['description'] }}</div>
                </div>
            @endforeach
        @else
            @foreach (config('hosting-features') as $data)
                <div class="website">
                    <div class="image cursor-pointer">
                        <img src="{{ asset('assets/images/website/' . $data['image']) }}" alt="{{ __('main.' . $data['title']) }}">
                    </div>
                    <div class="title font-semibold">{{ __('main.' . $data['title']) }}</div>
                    <div class="description">{{ __('main.' . $data['description']) }}</div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-hosting-features</div>
    @endif
</section>
