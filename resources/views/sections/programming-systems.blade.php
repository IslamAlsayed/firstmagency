<section class="section programming-section text-center relative">
    <div class="title font-semibold">{{ __('main.programming_title') }} <span class="title-badge">{{ __('main.programming_subtitle') }}</span></div>
    <div class="description">{{ __('main.programming_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @if ($programming_systems && count($programming_systems) > 0)
            @foreach ($programming_systems as $data)
                <a href="" class="website clickable-img" data-src="{{ asset('storage/' . $data->image) }}">
                    <div class="image">
                        <img src="{{ asset('storage/' . $data->image) }}" alt="{{ $data->title }}">
                    </div>
                    <div class="title font-semibold">{{ $data->title }}</div>
                </a>
            @endforeach
        @else
            @if (config('programming-systems') && count(config('programming-systems')) > 0)
                @foreach (config('programming-systems') as $data)
                    <a href="" class="website clickable-img" data-src="{{ asset('assets/images/website/developer/' . $data['image']) }}">
                        <div class="image">
                            <img src="{{ asset('assets/images/website/developer/' . $data['image']) }}" alt="{{ $data['title'] }}">
                        </div>
                        <div class="title font-semibold">{{ $data['title'] }}</div>
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
