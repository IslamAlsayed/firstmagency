<section class="project-steps">
    <h2 class="section-title">{{ __('main.project_steps_title') }}</h2>
    <p class="section-subtitle">
        {{ __('main.project_steps_subtitle') }}
    </p>

    <div class="timeline">
        <!-- التحليل -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>{{ __('main.project_step_analysis') }}</span>
                    <i class="fas fa-arrow-left"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-chart-pie"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.project_step_analysis_content') }}
            </div>
        </div>

        <!-- التصميم -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>{{ __('main.project_step_design') }}</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-pencil-ruler"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.project_step_design_content') }}
            </div>
        </div>

        <!-- البرمجة -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>{{ __('main.project_step_programming') }}</span>
                    <i class="fas fa-arrow-left"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-code"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.project_step_programming_content') }}
            </div>
        </div>

        <!-- النتائج -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>{{ __('main.project_step_results') }}</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-desktop"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.project_step_results_content') }}
            </div>
        </div>
    </div>
</section>
