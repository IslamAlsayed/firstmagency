<section class="section clients-section text-center relative" id="clients">
    <div class="title font-semibold">{{ __('main.clients_title') }} <span class="title-badge">{{ __('main.clients_subtitle') }}</span></div>
    <div class="description">{{ __('main.clients_description') }}</div>

    <div class="clients-items grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @if (isset($clients) && count($clients) > 0)
            @foreach ($clients as $client)
                @php
                    $image = is_object($client) ? $client->image : $client['image'] ?? '';
                    $altText = is_object($client) ? $client->alt_text ?? '' : $client['alt_text'] ?? '';
                    $slug = is_object($client) ? $client->slug : $client['slug'] ?? '';
                    $website = is_object($client) ? $client->website ?? '#' : $client['website'] ?? '#';
                    $locale = app()->getLocale();
                    if (is_object($client)) {
                        $title = $client->translations[$locale]['name'] ?? $slug;
                    } else {
                        $title = $client['translations'][$locale]['name'] ?? $slug;
                    }
                @endphp
                <a href="{{ $website }}" target="_blank" class="client" title="{{ $title }}">
                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $altText ?? $slug }}" loading="lazy">
                </a>
            @endforeach
        @else
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">{{ __('main.no_clients_found') }}</p>
            </div>
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-clients</div>
    @endif
</section>
