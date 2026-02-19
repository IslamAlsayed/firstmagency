<div class="section faqs-section text-center">
    <div class="title font-semibold">أسئلة <span class="title-badge">شائعة</span></div>
    <div class="description">إجابات سريعة وواضحة لأكثر الأسئلة تكرارًا — لو محتاج مساعدة إضافية تواصل معنا في أي وقت.</div>

    <div class="questions-items flex flex-col gap-3">
        @if (isset($faqs) && !empty($faqs))
            @foreach ($faqs as $faq)
                <div class="question-item text-right" data-faq-item>
                    <div class="question font-semibold cursor-pointer" data-faq-toggle>
                        {{ $faq['question'] }}
                        <span class="open">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <div class="answer text-sm text-gray-600" data-faq-answer>{{ $faq['answer'] }}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>
