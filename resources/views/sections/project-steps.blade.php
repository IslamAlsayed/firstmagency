<section class="project-steps relative">
    <h2 class="section-title">{{ __('main.project_steps_title') }}</h2>
    <p class="section-subtitle">
        {{ __('main.project_steps_subtitle') }}
    </p>

    <div class="timeline">
        @if ($steps && count($steps) > 0)
            @foreach ($steps as $step)
                <div class="timeline-item flex items-center">
                    <div class="step-label font-semibold">
                        <div class="label">
                            <span>{{ $step->translations[app()->getLocale()]['title'] ?? $step->slug }}</span>
                            <i class="arrow-icon fas fa-arrow-{{ $loop->index % 2 === 0 ? 'left' : 'right' }}"></i>
                        </div>
                    </div>

                    <div class="timeline-icon">
                        @if ($step->icon)
                            <i class="{{ $step->icon }}"></i>
                        @else
                            <i class="fas fa-circle"></i>
                        @endif
                    </div>

                    <div class="timeline-content">
                        {{ $step->translations[app()->getLocale()]['content'] ?? '' }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="timeline-item flex items-center">
                <div class="step-label font-semibold">
                    <div class="label">
                        <span>{{ __('main.project_step_analysis') }}</span>
                        <i class="arrow-icon fas fa-arrow-left"></i>
                    </div>
                </div>

                <div class="timeline-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>

                <div class="timeline-content">
                    {{ __('main.project_step_analysis_content') }}
                </div>
            </div>

            <div class="timeline-item flex items-center">
                <div class="step-label font-semibold">
                    <div class="label">
                        <span>{{ __('main.project_step_design') }}</span>
                        <i class="arrow-icon fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="timeline-icon">
                    <i class="fas fa-pencil-ruler"></i>
                </div>

                <div class="timeline-content">
                    {{ __('main.project_step_design_content') }}
                </div>
            </div>

            <div class="timeline-item flex items-center">
                <div class="step-label font-semibold">
                    <div class="label">
                        <span>{{ __('main.project_step_programming') }}</span>
                        <i class="arrow-icon fas fa-arrow-left"></i>
                    </div>
                </div>

                <div class="timeline-icon">
                    <i class="fas fa-code"></i>
                </div>

                <div class="timeline-content">
                    {{ __('main.project_step_programming_content') }}
                </div>
            </div>

            <div class="timeline-item flex items-center">
                <div class="step-label font-semibold">
                    <div class="label">
                        <span>{{ __('main.project_step_results') }}</span>
                        <i class="arrow-icon fas fa-arrow-right"></i>
                    </div>
                </div>

                <div class="timeline-icon">
                    <i class="fas fa-desktop"></i>
                </div>

                <div class="timeline-content">
                    {{ __('main.project_step_results_content') }}
                </div>
            </div>
        @endif
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-project-steps</div>
    @endif
</section>
