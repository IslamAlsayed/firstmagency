<section class="section payments-section text-center relative">
    <div class="title font-semibold">بوابات الدفع المتاحة لحجز النطاقات</div>
    <div class="description">نقبل الدفع للنطاقات بأمان عبر وسائل متعددة — اختر الطريقة الأنسب لك وأكمل الحجز خلال دقائق.</div>

    <div class="payments-items flex flex-wrap justify-center gap-4">
        @if (isset($payments) && !empty($payments))
            @foreach ($payments as $payment)
                <div class="payment-image">
                    <img src="{{ asset('assets/images/website/payments/' . $payment['image']) }}" alt="{{ $payment['label'] }}" class="clickable-img" loading="lazy"
                        data-src="{{ asset('assets/images/website/payments/' . $payment['image']) }}">
                    <span class="payment-label">{{ app()->getLocale() == 'ar' ? limitedText($payment['label_ar'], 15) : limitedText($payment['label'], 15) }}</span>
                </div>
            @endforeach
        @endif
    </div>
</section>
