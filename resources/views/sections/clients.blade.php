<div class="container section clients-section text-center">
    <div class="title font-semibold">{{ __('main.clients_title') }} <span class="title-badge">{{ __('main.clients_subtitle') }}</span></div>
    <div class="description">{{ __('main.clients_description') }}</div>

    <div class="our-clients-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @for ($i = 1; $i <= 12; $i++)
            <a href="#" class="client">
                <img src="{{ asset('assets/images/clients/' . $i . '.png') }}" alt="Client {{ $i }}">
            </a>
        @endfor
    </div>
</div>
