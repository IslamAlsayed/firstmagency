<section class="section programming-section text-center relative">
    <div class="title font-semibold">{{ __('main.programming_title') }} <span class="title-badge">{{ __('main.programming_subtitle') }}</span></div>
    <div class="description">{{ __('main.programming_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @if ($websites && count($websites) > 0)
            @foreach ($websites as $website)
                <a href="" class="website">
                    <div class="image">
                        <img src="{{ asset('storage/' . $website->image) }}" alt="{{ $website->translations[app()->getLocale()]['title'] }}">
                    </div>
                    <div class="title font-semibold">{{ $website->translations[app()->getLocale()]['title'] }}</div>
                </a>
            @endforeach
        @else
            @if (config('websites') && count(config('websites')) > 0)
                @foreach (config('websites') as $website)
                    <a href="" class="website">
                        <div class="image">
                            <img src="{{ asset($website['image']) }}" alt="{{ $website['title'] }}">
                        </div>
                        <div class="title font-semibold">{{ $website['title'] }}</div>
                    </a>
                @endforeach
            @else
                <p>{{ __('messages.no_records_found') }}</p>
            @endif
        @endif
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-programming</div>
    @endif
</section>
