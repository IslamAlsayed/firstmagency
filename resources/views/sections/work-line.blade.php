<section class="section work-lines-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold">
            {{ __('main.line_works_title') }}
        </div>
        <p class="description text-gray-600">{{ __('main.work_line_description') }}</p>
    </div>

    <div class="steps flex items-center justify-between gap-6">
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/content-marketing.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.performance_analysis') }}</h3>
        </article>
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/map.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.strategy_planning') }}</h3>
        </article>
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/planning.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.start_work') }}</h3>
        </article>
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/qatar-marketing.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.content_planning') }}</h3>
        </article>
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/strategy-development.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.content_development') }}</h3>
        </article>
        <article class="step">
            <div class="step-line"></div>
            <p class="image">
                <img src="{{ asset('assets/images/website/services-marketing/work-lines/targeted.png') }}" alt="">
            </p>
            <h3 class="step-title font-semibold">{{ __('main.competitor_research') }}</h3>
        </article>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-work-line</div>
    @endif
</section>


{{-- <section class="section work-lines-sections text-center relative">
    <div class="mb-8">
        <div class="title font-semibold">
            {{ __('main.line_works_title') }}
        </div>
        <p class="description text-gray-600">{{ __('main.work_line_description') }}</p>
    </div>

    @php
        $works = \App\Models\WorkUsStep::active()->published()->ordered()->get();
    @endphp

    <div class="steps flex items-center justify-between gap-6">
        @forelse($works as $work)
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    @if ($work->image && \App\Helpers\SettingsHelper::checkExistFile($work->image))
                        <img src="{{ asset('storage/' . $work->image) }}" alt="{{ $work->alt_text ?? ($work->translations[app()->getLocale()]['title'] ?? '') }}">
                    @else
                        <img src="{{ asset('assets/images/website/services-marketing/work-lines/placeholder.png') }}" alt="placeholder">
                    @endif
                </p>
                <h3 class="step-title font-semibold">{{ $work->translations[app()->getLocale()]['title'] ?? ($work->translations['en']['title'] ?? '') }}</h3>
            </article>
        @empty
            <!-- Fallback Static Content -->
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/content-marketing.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.performance_analysis') }}</h3>
            </article>
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/map.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.strategy_planning') }}</h3>
            </article>
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/planning.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.start_work') }}</h3>
            </article>
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/qatar-marketing.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.content_planning') }}</h3>
            </article>
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/strategy-development.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.content_development') }}</h3>
            </article>
            <article class="step">
                <div class="step-line"></div>
                <p class="image">
                    <img src="{{ asset('assets/images/website/services-marketing/work-lines/targeted.png') }}" alt="">
                </p>
                <h3 class="step-title font-semibold">{{ __('main.competitor_research') }}</h3>
            </article>
        @endforelse
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-work-line</div>
    @endif
</section> --}}
