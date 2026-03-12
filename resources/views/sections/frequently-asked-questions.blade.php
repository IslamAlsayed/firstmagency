<section class="section faqs-section text-center relative">
    <div class="title font-semibold">{{ __('main.faqs_title') }} <span class="title-badge">{{ __('main.faqs_badge') }}</span></div>
    <div class="description">{{ __('main.faqs_description') }}</div>

    <div class="questions-items flex flex-col gap-3">
        @if (isset($faqs) && !empty($faqs))
            @foreach ($faqs as $faq)
                <div class="question-item text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} {{ $loop->first ? 'active' : '' }}" data-faq-item>
                    <div class="question font-semibold cursor-pointer" data-faq-toggle>
                        @if (app()->getLocale() == 'ar')
                            {!! $faq['question_ar'] ?? $faq['question'] !!}
                        @else
                            {!! $faq['question'] !!}
                        @endif
                        <span class="open">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <div class="answer text-sm text-gray-600" data-faq-answer>
                        @if (app()->getLocale() == 'ar')
                            {!! $faq['answer_ar'] ?? $faq['answer'] !!}
                        @else
                            {!! $faq['answer'] !!}
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-faq</div>
    @endif
</section>
