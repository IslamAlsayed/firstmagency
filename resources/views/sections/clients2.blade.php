<div class="section clients-section text-center">
    <div class="title font-semibold">{{ __('main.clients_title') }} <span class="title-badge">{{ __('main.clients_subtitle') }}</span></div>
    <div class="description">{{ __('main.clients_description') }}</div>

    <div class="clients-carousel">
        <!-- صف أول -->
        <div class="carousel-row">
            <div class="our-clients-wrapper left">
                @for ($i = 0; $i < 24; $i++)
                    <a href="#" class="client">
                        <img src="{{ asset('assets/images/clients/' . (($i % 6) + 1) . '.png') }}" alt="Client {{ $i + 1 }}">
                    </a>
                @endfor
                @for ($i = 0; $i < 24; $i++)
                    <a href="#" class="client">
                        <img src="{{ asset('assets/images/clients/' . (($i % 6) + 1) . '.png') }}" alt="Client {{ $i + 1 }}">
                    </a>
                @endfor
            </div>
        </div>

        <!-- صف ثاني -->
        <div class="carousel-row">
            <div class="our-clients-wrapper right">
                @for ($i = 0; $i < 24; $i++)
                    <a href="#" class="client">
                        <img src="{{ asset('assets/images/clients/' . (($i % 6) + 1) . '.png') }}" alt="Client {{ $i + 1 }}">
                    </a>
                @endfor
                @for ($i = 0; $i < 24; $i++)
                    <a href="#" class="client">
                        <img src="{{ asset('assets/images/clients/' . (($i % 6) + 1) . '.png') }}" alt="Client {{ $i + 1 }}">
                    </a>
                @endfor
            </div>
        </div>
    </div>
</div>
