<section class="section pest-domains-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_best_offers') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domains_best_description') }}</p>
    </div>

    <div class="content items-center">
        @php
            $pestDomainsList = isset($domains) && count($domains) > 0 ? $domains : config('pest-domains') ?? [];
        @endphp
        @if ($pestDomainsList && count($pestDomainsList) > 0)
            @foreach ($pestDomainsList as $domain)
                <div class="domain-card p-3 font-semibold flex flex-col items-center justify-center relative"
                    data-extension="{{ $domain instanceof \App\Models\PestDomain ? $domain->slug : $domain['extension'] ?? '' }}">

                    {{-- Discount Badge --}}
                    @if ($domain instanceof \App\Models\PestDomain)
                        @if ($domain->discount_percentage && $domain->discount_percentage > 0)
                            <div class="mb-2 bg-red-500 text-white px-2 py-1 rounded-full text-sm font-bold">
                                {{ __('main.discount') }}
                            </div>
                        @endif
                    @elseif (isset($domain['discount_percentage']) && $domain['discount_percentage'] > 0)
                        <div class="mb-2 bg-red-500 text-white px-2 py-1 rounded-full text-sm font-bold">
                            -{{ $domain['discount_percentage'] }}%
                        </div>
                    @endif

                    <div class="image">
                        @if ($domain instanceof \App\Models\PestDomain)
                            @if ($domain->image)
                                <img src="{{ asset('storage/' . $domain->image) }}" alt="{{ $domain->slug ?? '' }}" class="clickable-img" loading="lazy"
                                    data-src="{{ asset('storage/' . $domain->image) }}">
                            @else
                                <i class="fas fa-globe text-4xl text-gray-400"></i>
                            @endif
                        @endif
                    </div>

                    {{-- Price Display --}}
                    @if ($domain instanceof \App\Models\PestDomain)
                        <div class="price-section">
                            @if ($domain->discount_percentage && $domain->discount_percentage > 0)
                                <small class="text-gray-600 line-through text-xs">${{ number_format($domain->old_price, 2) }}</small>
                            @endif
                            <h3 class="text-lg font-bold">
                                $<span class="price-value">{{ number_format($domain->price, 2) }}</span>
                            </h3>
                        </div>
                    @else
                        <div class="price-section">
                            @if (isset($domain['old_price']) && $domain['old_price'] > 0)
                                <small class="text-gray-600 line-through text-xs">${{ number_format($domain['old_price'], 2) }}</small>
                            @endif
                            <h3 class="text-lg font-bold">
                                $<span class="price-value">{{ number_format($domain['price'], 2) }}</span>
                            </h3>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-pest-domains</div>
    @endif
</section>
