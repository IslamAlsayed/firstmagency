@extends('layouts.master')

@section('content')
    <div class="contact-sections">
        <div class="text">
            <div class="title font-semibold mb-4">كتابة بياناتك حتي نتمكن من التواصل معك</div>
            <button class="btn-link light-main-color dark-hover font-semibold mb-8">
                <a href="{{ route('tickets') }}">الاستعلام عن التذكرة / الطلب</a>
            </button>
        </div>

        <div class="container contact-form">
            <div class="text">
                <h2>تسجيل تذكرة</h2>
                <p>اكتب بياناتك وسيتم التواصل معك في أقرب وقت.</p>
            </div>

            <div class="groups">
                <div class="group flex items-center">
                    {{-- name --}}
                    <div>
                        <label for="name" class="font-semibold">
                            الاسم
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex">
                            <input type="text" id="name" placeholder="الاسم">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/user.svg') }}" alt="user">
                            </div>
                        </div>
                    </div>
                    {{-- email --}}
                    <div>
                        <label for="email" class="font-semibold">
                            البريد الإلكتروني
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex">
                            <input type="email" id="email" placeholder="البريد الإلكتروني">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/email.svg') }}" alt="email">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex items-center">
                    {{-- phone --}}
                    <div>
                        <label for="phone" class="font-semibold">رقم الهاتف</label>
                        <div class="input flex">
                            <input type="text" id="phone" placeholder="رقم الهاتف">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/phone.svg') }}" alt="phone">
                            </div>
                        </div>
                    </div>
                    {{-- اختيار القسم --}}
                    <div>
                        <label for="department" class="font-semibold">
                            اختيار القسم
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex">
                            <select id="department">
                                <option value="">اختر القسم</option>
                                <option value="sales">المبيعات</option>
                                <option value="support">الدعم الفني</option>
                                <option value="general">عام</option>
                            </select>
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/pin.svg') }}" alt="pin">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group flex items-center">
                    {{-- موضوع الرسالة --}}
                    <div>
                        <label for="subject" class="font-semibold">
                            موضوع الرسالة
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex">
                            <input type="text" id="subject" placeholder="مثال: حجز موعد او استفسار">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/sheet.svg') }}" alt="sheet">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group flex items-center">
                    {{-- الرسالة --}}
                    <div>
                        <label for="message" class="font-semibold">
                            الرسالة
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="input flex">
                            <textarea id="message" rows="5" placeholder="اكتب رسالتك هنا"></textarea>
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/message.svg') }}" alt="message">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    {{-- مرفق (اختياري) --}}
                    <label for="attachment" class="font-semibold mb-2 block">مرفق (اختياري)</label>
                    <div class="attachments flex flex-col gap-4" id="attachments-container">
                        <div class="input flex">
                            <input type="file" id="attachment">
                        </div>
                    </div>

                    <div class="add-attachment-input" id="add-attachment-btn" style="cursor: pointer;">
                        إضافة مرفق آخر
                    </div>
                </div>

                <div class="group">
                    {{-- تحقق --}}
                    <label for="verification" class="font-semibold block mb-2">تحقق</label>
                    <div class="verification">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex inter gap-4">
                                <button class="rotate"><i class="fas fa-arrow-rotate-right"></i></button>
                                <div class="input flex items-center">
                                    <input type="text" id="verification" placeholder="الاجابة">
                                </div>
                            </div>
                            <div class="question font-semibold">تحقق: ? = {{ rand(1, 9) }} + {{ rand(1, 9) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('add-attachment-btn').addEventListener('click', function() {
            const container = document.getElementById('attachments-container');

            for (let i = 0; i < 2; i++) {
                const div = document.createElement('div');
                div.className = 'input flex';
                div.innerHTML = '<input type="file">';
                container.appendChild(div);
            }
        });
    </script>
@endsection
