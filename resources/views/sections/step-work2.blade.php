<style>
    .project-steps {
        padding: 100px var(--inline-padding);
        background: #f4f4f4;
        text-align: center;
    }

    .project-steps .section-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .project-steps .section-subtitle {
        color: #777;
        margin-bottom: 70px;
    }

    /* Timeline Container */
    .timeline {
        position: relative;
        max-width: 1100px;
        margin: auto;
    }

    /* Vertical Line */
    .timeline::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 100%;
        background: #e2a623;
    }

    /* Timeline Item */
    .timeline-item {
        position: relative;
        width: 50%;
        padding: 20px 50px;
        box-sizing: border-box;
    }

    /* Right Side */
    .timeline-item.right {
        right: 0;
        text-align: right;
    }

    /* Left Side */
    .timeline-item.left {
        left: 0;
        text-align: left;
    }

    /* Circle Icon */
    .timeline-icon {
        position: absolute;
        top: 30px;
        left: 50%;
        transform: translate(-50%, 0);
        width: 70px;
        height: 70px;
        background: #2f3a3f;
        border-radius: 50%;
        border: 6px solid #f4f4f4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f4b400;
        font-size: 22px;
        z-index: 2;
    }

    /* Content Box */
    .timeline-content {
        background: #fff;
        padding: 25px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        font-size: 15px;
        line-height: 1.8;
        color: #666;
    }

    /* Yellow Label Button */
    .step-label {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f4b400;
        color: #000;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 18px;
        position: relative;
        margin-bottom: 20px;
    }

    /* Arrow shape */
    .step-label::after {
        content: "";
        position: absolute;
        top: 0;
        width: 0;
        height: 0;
        border-top: 28px solid transparent;
        border-bottom: 28px solid transparent;
    }

    .timeline-item.right .step-label::after {
        right: -20px;
        border-left: 20px solid #f4b400;
    }

    .timeline-item.left .step-label::after {
        left: -20px;
        border-right: 20px solid #f4b400;
    }

    /* Responsive */
    /* @media (max-width: 992px) {

        .timeline::before {
            left: 20px;
        }

        .timeline-item {
            width: 100%;
            padding-right: 0;
            padding-left: 70px;
            margin-bottom: 60px;
            text-align: right !important;
        }

        .timeline-icon {
            left: 20px;
            transform: none;
        }

        .step-label::after {
            display: none;
        }
    } */
</style>

<section class="project-steps">
    <h2 class="section-title">{{ __('main.project_steps_title') }}</h2>
    <p class="section-subtitle">
        {{ __('main.project_steps_subtitle') }}
    </p>

    <div class="timeline">

        <!-- التحليل -->
        <div class="timeline-item right">
            <div class="timeline-icon">
                <i class="fas fa-chart-pie"></i>
            </div>

            <div class="step-label">
                {{ __('main.step_work2_analysis_title') }} <i class="fas fa-arrow-left"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.step_work2_analysis_description') }}
            </div>
        </div>

        <!-- التصميم -->
        <div class="timeline-item left">
            <div class="timeline-icon">
                <i class="fas fa-pencil-ruler"></i>
            </div>

            <div class="step-label">
                <i class="fas fa-arrow-right"></i> {{ __('main.step_work2_design_title') }}
            </div>

            <div class="timeline-content">
                {{ __('main.step_work2_design_description') }}
            </div>
        </div>

        <!-- البرمجة -->
        <div class="timeline-item right">
            <div class="timeline-icon">
                <i class="fas fa-code"></i>
            </div>

            <div class="step-label">
                {{ __('main.step_work2_programming_title') }} <i class="fas fa-arrow-left"></i>
            </div>

            <div class="timeline-content">
                {{ __('main.step_work2_programming_description') }}
            </div>
        </div>

        <!-- النتائج -->
        <div class="timeline-item left">
            <div class="timeline-icon">
                <i class="fas fa-desktop"></i>
            </div>

            <div class="step-label">
                <i class="fas fa-arrow-right"></i> {{ __('main.step_work2_results_title') }}
            </div>

            <div class="timeline-content">
                {{ __('main.step_work2_results_description') }}
            </div>
        </div>
    </div>
</section>
