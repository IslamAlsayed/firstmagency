<section class="section partners-section text-center relative">
    <div class="title font-semibold">{{ __('main.partners_title') }} <span class="title-badge">{{ __('main.brand_short') }}</span></div>
    <div class="description">{{ __('main.partners_description') }}</div>

    <div class="our-partners-wrapper">
        @for ($i = 1; $i <= 6; $i++)
            <div class="partner">
                <a href="">
                    <img src="{{ asset('assets/images/website/partners/' . $i . '.png') }}" alt="{{ __('main.partners_item') }} {{ $i }}">
                </a>
            </div>
        @endfor
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-partners</div>
    @endif
</section>

{{-- <section class="section partners-section text-center">
    <div class="title font-semibold">{{ __('main.partners_title') }} <span class="title-badge">{{ __('main.brand_short') }}</span></div>
    <div class="description">{{ __('main.partners_description') }}</div>

    <div class="our-partners-wrapper">
        @php
            $partners = \App\Models\Partner::active()->published()->ordered()->get();
        @endphp

        @if ($partners->count() > 0)
            @foreach ($partners as $partner)
                <div class="partner">
                    @if ($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" title="{{ $partner->translations[app()->getLocale()]['name'] ?? '' }}">
                            @if ($partner->image && checkExistFile($partner->image))
                                <img src="{{ asset('storage/' . $partner->image) }}"
                                    alt="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}">
                            @else
                                <div class="flex items-center justify-center h-24 bg-gray-200 rounded">
                                    <i class="fas fa-users text-3xl text-gray-400"></i>
                                </div>
                            @endif
                        </a>
                    @else
                        <div title="{{ $partner->translations[app()->getLocale()]['name'] ?? '' }}">
                            @if ($partner->image && checkExistFile($partner->image))
                                <img src="{{ asset('storage/' . $partner->image) }}"
                                    alt="{{ $partner->alt_text ?? ($partner->translations[app()->getLocale()]['name'] ?? '') }}">
                            @else
                                <div class="flex items-center justify-center h-24 bg-gray-200 rounded">
                                    <i class="fas fa-users text-3xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            @for ($i = 1; $i <= 6; $i++)
                <div class="partner">
                    <a href="">
                        <img src="{{ asset('assets/images/website/partners/' . $i . '.png') }}" alt="{{ __('main.partners_item') }} {{ $i }}">
                    </a>
                </div>
            @endfor
        @endif
    </div>
</section> --}}
