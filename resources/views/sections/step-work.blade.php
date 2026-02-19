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
        margin-bottom: 70px;
        color: var(--muted-color);
    }

    .timeline {
        width: 70%;
        margin: auto;
        position: relative;
        padding-block: 30px;

        --color: #F4B42A;

        /* line in center from top to bottom */
        &:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 5px;
            height: 100%;
            border-radius: 25px;
            background: var(--color);
            transform: translateX(-50%);
        }

    }

    .timeline .timeline-item {
        gap: 30px;
        margin-bottom: 30px;

        &>div:first-child,
        &>div:last-child {
            width: 40%;
            margin: auto;
        }
    }

    .timeline .timeline-item .step-label .label {
        width: 300px;
        padding: 10px;
        font-size: 26px;
        border-radius: 10px;
        position: relative;
        z-index: 10;

        &:before {
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            right: auto;
            z-index: -1;
            border-radius: inherit;
            transform: translate(-50%, -50%);
            background: var(--color);
        }

        &:after {
            content: '';
            width: 30px;
            height: 30px;
            position: absolute;
            top: 50%;
            left: calc((25px / 2) * -1);
            z-index: -1;
            transform: translateY(-50%) rotate(45deg);
            background: var(--color);
        }

        & i,
        & svg {
            transform: translateX(-40px) scaleX(-1);
            color: var(--light-color);
        }
    }

    .timeline .timeline-item {
        &:nth-child(odd) {
            flex-direction: row-reverse;
        }

        &:nth-child(even) {
            & .step-label .label {
                right: 50px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-direction: row-reverse;


                &:after {
                    right: calc((30px / 2) * -1);
                    left: auto;
                    transform: translateY(-50%) rotate(45deg);
                }

                & i,
                & svg {
                    transform: translateX(40px) scaleX(-1);
                }
            }
        }
    }

    .timeline .timeline-item .timeline-content {
        padding: 15px;
        font-size: 14px;
        line-height: 1.8;
        border-radius: 15px;
        text-align: start;
        background: var(--light-color);
        box-shadow: 0 10px 26px rgba(0, 0, 0, .08);
    }

    .timeline .timeline-item .timeline-icon {
        width: 90px;
        height: 90px;
        display: flex;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        background: var(--light-color);
        position: relative;
        z-index: 54;

        & i,
        & svg {
            font-size: 28px;
            color: var(--color);
        }

        &:before {
            content: '';
            width: calc(100% - 30px);
            height: calc(100% - 30px);
            position: absolute;
            top: 50%;
            left: 50%;
            right: auto;
            z-index: -1;
            border-radius: inherit;
            transform: translate(-50%, -50%);
            background: var(--bg-text);
            box-shadow: 0 10px 26px rgba(0, 0, 0, .08);
        }

        &:after {
            content: '';
            width: calc(100% + 15px);
            height: calc(100% + 15px);
            position: absolute;
            top: 50%;
            left: 50%;
            right: auto;
            z-index: -1;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            border-style: solid;
            border-width: 7px;
            border-color: var(--color) var(--color) transparent transparent;
        }
    }

    .timeline .timeline-item:hover .timeline-icon {

        & i,
        & svg {
            animation: scale 1s linear infinite;
        }

        &:after {
            animation: rotate 5s linear infinite;
        }
    }

    @keyframes scale {
        0% {
            transform: translateY(-2px) scale(1);
        }

        50% {
            transform: translateY(-2px) scale(1.1);
        }

        100% {
            transform: translateY(-2px) scale(1);
        }
    }

    @keyframes rotate {
        0% {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(405deg);
        }
    }

    @media(max-width: 992px) {
        .timeline {
            width: 100%;
        }

        .timeline .timeline-item {
            flex-direction: column !important;
        }

        .timeline .timeline-item .timeline-content {
            font-size: 12px;
        }

        .timeline .timeline-item .step-label .label {
            width: 200px;
            font-size: 20px;
        }
    }

    @media(max-width: 768px) {
        .project-steps {
            padding: 100px var(--inline-padding);
        }

        .project-steps .section-title {
            text-align: start;
            font-size: 24px;
        }

        .project-steps .section-subtitle {
            text-align: start;
            font-size: 16px;
            margin-bottom: 30px;
            color: var(--muted-color);
        }

        .timeline .timeline-item {
            position: relative;
            z-index: 56;

            &>div:first-child,
            &>div:last-child {
                width: 100%;
            }
        }

        .timeline .timeline-item .timeline-icon {
            order: -1;
        }

        .timeline .timeline-item .step-label .label {
            width: 100%;
            right: auto !important;
            left: auto !important;

            &:after {
                display: none;
            }

            & i,
            & svg {
                display: none;
            }
        }
    }
</style>

<section class="project-steps">
    <h2 class="section-title">مراحل تنفيذ مشروعك</h2>
    <p class="section-subtitle">
        نشتغل بخطة واضحة من التحليل حتى التسليم… علشان نضمن نتيجة قوية.
    </p>

    <div class="timeline">
        <!-- التحليل -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>التحليل</span>
                    <i class="fas fa-arrow-left"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-chart-pie"></i>
            </div>

            <div class="timeline-content">
                تحليل المشروع يعتبر من أهم مراحل المشروع البرمجي حيث يتم في هذه المرحلة الاقتراب أكثر من العملاء لفهم المشروع وتحديد متطلباته وحذف المفاهيم
                الغير منطقية وفهم المشروع بشكل أكبر فهي تعتبر خطوة لتحديد الطلب
            </div>
        </div>

        <!-- التصميم -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>التصميم</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-pencil-ruler"></i>
            </div>

            <div class="timeline-content">
                تميز بتقديم تصميم المواقع والتطبيقات ذات الطابع الخاص والمتميز ولا ينتهي تصميم المواقع لدينا عند تسليم الموقع بل دائماً متواجدين لتقديم الدعم
                بشكل مستمر ونسعد بتقديم الإستشارات القيمة لمشروعك
            </div>
        </div>

        <!-- البرمجة -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>البرمجة</span>
                    <i class="fas fa-arrow-left"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-code"></i>
            </div>

            <div class="timeline-content">
                برمجيات شركة فرست ماركتينج تتميز بالدقة والإبداع وإتقان البرمجة القوية دائماً قابلة للتطوير ضمن لا نقوم باستخدام أي من القوالب أو السكربتات
                الجاهزة أو الأكواد المشفرة
            </div>
        </div>

        <!-- النتائج -->
        <div class="timeline-item flex items-center">
            <div class="step-label font-semibold">
                <div class="label">
                    <span>النتائج</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>

            <div class="timeline-icon">
                <i class="fas fa-desktop"></i>
            </div>

            <div class="timeline-content">
                ما يميز فرست ماركتينج هي النتائج، لا نقوم بمراجعة المشاريع أكثر من 3 مرات حتى يقوم العميل باستلام المشروع الخاص به جاهز دون أي مشاكل
            </div>
        </div>
    </div>
</section>
