<div class="section clients-section text-center">
    <div class="title font-semibold">{{ __('main.clients_title') }} <span class="title-badge">{{ __('main.clients_subtitle') }}</span></div>
    <div class="description">{{ __('main.clients_description') }}</div>

    <div class="clients-items grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @for ($i = 0; $i < 12; $i++)
            <a href="#" class="client">
                <img src="{{ asset('assets/images/clients/' . (($i % 6) + 1) . '.png') }}" alt="Client {{ $i + 1 }}">
            </a>
        @endfor
    </div>
</div>
