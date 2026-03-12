<section class="section programming-section why-us-section text-center relative">
    <div class="title font-semibold">{{ __('main.why_us_title') }}</div>
    <div class="description">{{ __('main.why_us_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @php
            $whyUsItems = isset($whyUs) && count($whyUs) > 0 ? $whyUs : config('why-us') ?? [];
        @endphp

        @if ($whyUsItems && count($whyUsItems) > 0)
            @foreach ($whyUsItems as $item)
                <div class="website">
                    <div class="image cursor-pointer">
                        @if (isset($item->image) && $item->image)
                            @if (checkExistFile($item->image))
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->translations[app()->getLocale()]['title'] ?? ($item->title ?? '') }}">
                            @else
                                <i class="fas fa-star text-4xl text-gray-400"></i>
                            @endif
                        @elseif (isset($item->icon) && $item->icon)
                            <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->title ?? '' }}">
                        @else
                            <i class="fas fa-star text-4xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="website-title font-semibold">
                        {{ $item->translations[app()->getLocale()]['title'] ?? ($item->title ?? '') }}
                    </div>
                    <div class="website-description">
                        {{ $item->translations[app()->getLocale()]['description'] ?? ($item->description ?? '') }}
                    </div>
                </div>
            @endforeach
        @else
            @foreach (config('why-us') as $item)
                <div class="website">
                    <div class="image cursor-pointer">
                        @if (isset($item['image']) && $item['image'])
                            @if (checkExistFile($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                    alt="{{ $item['translations'][app()->getLocale()]['title'] ?? ($item['title'] ?? '') }}">
                            @else
                                <i class="fas fa-star text-4xl text-gray-400"></i>
                            @endif
                        @elseif (isset($item['icon']) && $item['icon'])
                            <img src="{{ asset('assets/images/website/' . $item['icon']) }}" alt="{{ $item['title'] ?? '' }}">
                        @else
                            <i class="fas fa-star text-4xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="website-title font-semibold">
                        {{ $item['translations'][app()->getLocale()]['title'] ?? ($item['title'] ?? '') }}
                    </div>
                    <div class="website-description">
                        {{ $item['translations'][app()->getLocale()]['description'] ?? ($item['description'] ?? '') }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-why-us</div>
    @endif
</section>
