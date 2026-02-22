<div class="section programming-section text-center">
    <!-- AR: مميزات حجز الدومين | EN: Benefits of Domain Registration with First Marketing -->
    <div class="title font-semibold">{{ sprintf(__('main.domain_register_title')) }} {{ __('main.contact_us') }}</div>
    <div class="description">{{ __('main.why_us_description') }}</div>

    <div class="websites-items grid grid-cols-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @if (config('why-us') && count(config('why-us')) > 0)
            @foreach (config('why-us') as $item)
                <div class="website">
                    <div class="image cursor-pointer">
                        <img src="{{ asset('assets/images/' . $item['icon']) }}" alt="{{ $item['title'] }}">
                    </div>
                    <div class="website-title font-semibold">{{ $item['title'] }}</div>
                    <div class="website-description">{{ $item['description'] }}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>
