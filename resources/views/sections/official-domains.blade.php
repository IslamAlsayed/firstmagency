<section class="section pest-domains-sections official-domains text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_official_domains') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domain_official_domains_description') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        @if (config('official-domains') && count(config('official-domains')) > 0)
            @foreach (config('official-domains') as $domain)
                <div class="question-item text-right font-semibold" data-official-item>
                    <div class="question font-semibold cursor-pointer flex items-center justify-between gap-4" data-official-toggle>
                        <span class="open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        {{ $domain['title'] }}
                    </div>
                    <div class="details text-right" data-official-answer>
                        @foreach ($domain['children'] as $child)
                            {{-- <p>{{ $child['details'] }}</p> --}}
                            <div class="detail">
                                <div class="kt-badge mt-4 mb-4">{{ $child['badge'] }}</div>
                                <div class="answer text-sm text-gray-600" data-official-answer>{{ $child['details'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-official-domains</div>
    @endif
</section>


{{-- <section class="section official-domains-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_official_domains') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domain_official_domains_description') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        @php
            $officialDomains = \App\Models\OfficialDomain::active()->published()->ordered()->get();
        @endphp

        @if ($officialDomains->count() > 0)
            @foreach ($officialDomains as $domain)
                <div class="official-domain-item text-right font-semibold cursor-pointer">
                    @if ($domain->image && checkExistFile($domain->image))
                        <div class="domain-image mb-3">
                            <img src="{{ asset('storage/' . $domain->image) }}"
                                alt="{{ $domain->alt_text ?? ($domain->translations[app()->getLocale()]['name'] ?? '') }}" class="w-full h-auto rounded">
                        </div>
                    @endif
                    <h4 class="text-lg font-semibold">{{ $domain->translations[app()->getLocale()]['name'] ?? $domain->slug }}</h4>
                    @if ($domain->translations[app()->getLocale()]['description'] ?? null)
                        <p class="text-sm text-gray-600 mt-2">{{ $domain->translations[app()->getLocale()]['description'] }}</p>
                    @endif
                    @if ($domain->website)
                        <a href="{{ $domain->website }}" target="_blank" class="text-primary text-sm mt-2 inline-block">
                            {{ __('main.visit_website') }} <i class="fas fa-external-link-alt"></i>
                        </a>
                    @endif
                </div>
            @endforeach
        @elseif (config('official-domains') && count(config('official-domains')) > 0)
            @foreach (config('official-domains') as $domain)
                <div class="question-item text-right font-semibold" data-official-item>
                    <div class="question font-semibold cursor-pointer flex items-center justify-between gap-4" data-official-toggle>
                        <span class="open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        {{ $domain['title'] }}
                    </div>
                    <div class="details text-right" data-official-answer>
                        @foreach ($domain['children'] as $child)
                            <div class="detail">
                                <div class="kt-badge mt-4 mb-4">{{ $child['badge'] }}</div>
                                <div class="answer text-sm text-gray-600" data-official-answer>{{ $child['details'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-official-domains</div>
    @endif
</section>
 --}}
