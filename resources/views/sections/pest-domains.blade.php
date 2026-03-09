<section class="section pest-domains-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_best_offers') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domains_best_description') }}</p>
    </div>

    <div class="content items-center">
        @if (config('pest-domains') && count(config('pest-domains')) > 0)
            @foreach (config('pest-domains') as $domain)
                <div class="domain-card p-3 font-semibold flex flex-col items-center justify-center" data-extension="{{ $domain['extension'] }}">
                    <div class="image">
                        <img src="{{ asset('assets/images/website/' . $domain['icon']) }}" alt="">
                    </div>
                    @if (isset($domain['old_price']) && $domain['old_price'])
                        <small class="text-gray-600 line-through">${{ $domain['old_price'] }}</small>
                    @endif
                    <h3 class="">${{ $domain['price'] }}</h3>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-pest-domains</div>
    @endif
</section>

{{-- <section class="section pest-domains-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_best_offers') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domains_best_description') }}</p>
    </div>

    <div class="content items-center">
        @php
            $pestDomains = \App\Models\PestDomain::active()->published()->ordered()->get();
        @endphp

        @if ($pestDomains->count() > 0)
            @foreach ($pestDomains as $domain)
                <div class="domain-card p-3 font-semibold flex flex-col items-center justify-center">
                    @if ($domain->image && checkExistFile($domain->image))
                        <div class="image">
                            <img src="{{ asset('storage/' . $domain->image) }}"
                                alt="{{ $domain->alt_text ?? ($domain->translations[app()->getLocale()]['name'] ?? '') }}">
                        </div>
                    @else
                        <div class="image">
                            <i class="fas fa-globe text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    <h3 class="mt-2">{{ $domain->translations[app()->getLocale()]['name'] ?? '-' }}</h3>
                </div>
            @endforeach
        @elseif (config('pest-domains') && count(config('pest-domains')) > 0)
            @foreach (config('pest-domains') as $domain)
                <div class="domain-card p-3 font-semibold flex flex-col items-center justify-center" data-extension="{{ $domain['extension'] }}">
                    <div class="image">
                        <img src="{{ asset('assets/images/website/' . $domain['icon']) }}" alt="">
                    </div>
                    @if (isset($domain['old_price']) && $domain['old_price'])
                        <small class="text-gray-600 line-through">${{ $domain['old_price'] }}</small>
                    @endif
                    <h3 class="">${{ $domain['price'] }}</h3>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-pest-domains</div>
    @endif
</section> --}}
