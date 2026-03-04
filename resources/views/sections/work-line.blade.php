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
