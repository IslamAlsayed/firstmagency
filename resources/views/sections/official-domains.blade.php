<section class="section pest-domains-sections official-domains text-center relative">
    <div class="mb-8">
        <div class="title font-semibold mb-4">{{ __('main.domain_official_domains') }}</div>
        <p class="description text-gray-600 font-semibold">{{ __('main.domain_official_domains_description') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        @php
            $officialDomainsList = isset($domains) && count($domains) > 0 ? $domains : [];
        @endphp
        @if ($officialDomainsList && count($officialDomainsList) > 0)
            @foreach ($officialDomainsList as $domain)
                <div class="question-item text-right font-semibold" data-official-item>
                    <div class="question font-semibold cursor-pointer flex items-center justify-between gap-4" data-official-toggle>
                        <span class="open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        {{ $domain->title ?? $domain->slug }}
                    </div>
                    <div class="details text-right" data-official-answer>
                        @foreach ($domain->translations as $child)
                            <div class="detail">
                                <div class="kt-badge mt-4 mb-4">{{ $domain->translations[app()->getLocale()]['badge'] }}</div>
                                <div class="answer text-sm text-gray-600" data-official-answer>
                                    {{ $domain->translations[app()->getLocale()]['details'] ?? ($domain->translations[app()->getLocale()]['description'] ?? '') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            @if (config('official-domains') && count(config('official-domains')) > 0)
                @foreach (config('official-domains') as $child)
                    <div class="question-item text-right font-semibold" data-official-item>
                        <div class="question font-semibold cursor-pointer flex items-center justify-between gap-4" data-official-toggle>
                            <span class="open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            {{ $child['title'] }}
                        </div>
                        <div class="details text-right" data-official-answer>
                            @if ($child['translations'][app()->getLocale()] && count($child['translations'][app()->getLocale()]) > 0)
                                @foreach ($child['translations'][app()->getLocale()] as $childTranslation)
                                    <div class="detail">
                                        @if (isset($childTranslation['badge']))
                                            <div class="kt-badge mt-4 mb-4">{{ $childTranslation['badge'] }}</div>
                                        @endif
                                        <div class="answer text-sm text-gray-600" data-official-answer>
                                            {{ $childTranslation['details'] ?? ($childTranslation['description'] ?? '') }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-official-domains</div>
    @endif
</section>
