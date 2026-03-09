<section class="section programming-section why-us-section text-center relative">
    <div class="title font-semibold">{{ __('main.why_us_title') }}</div>
    <div class="description">{{ __('main.why_us_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @php
        $whyUsItems = \App\Models\WhyUs::active()->published()->ordered()->get();
        @endphp

        @if ($whyUsItems->count() > 0)
        @foreach ($whyUsItems as $item)
        <div class="website">
            @if ($item->image && checkExistFile($item->image))
            <div class="image cursor-pointer">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text ?? ($item->translations[app()->getLocale()]['title'] ?? '') }}">
            </div>
            @else
            <div class="image">
                <i class="fas fa-check text-4xl text-gray-400"></i>
            </div>
            @endif
            <div class="website-title font-semibold">{{ $item->translations[app()->getLocale()]['title'] ?? '-' }}</div>
            <div class="website-description">{{ $item->translations[app()->getLocale()]['description'] ?? '' }}</div>
        </div>
        @endforeach
        @elseif (config('why-us') && count(config('why-us')) > 0)
        @foreach (config('why-us') as $item)
        <div class="website">
            <div class="image cursor-pointer">
                <img src="{{ asset('assets/images/website/' . $item['icon']) }}" alt="{{ $item['title'] }}">
            </div>
            <div class="website-title font-semibold">{{ $item['title'] }}</div>
            <div class="website-description">{{ $item['description'] }}</div>
        </div>
        @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
    <div class="debug-flag-badge">🚩 flag-why-us</div>
    @endif
</section>