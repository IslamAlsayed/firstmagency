<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ __('main.ticket_rating') }}</title>
    <link href="{{ $settings->font_url ?? 'https://fonts.googleapis.com/css2?family=Tajawal:wght@100;200;300;400;500;600;700;800;900&display=swap' }}"
        rel="stylesheet">
    <style>
        :root {
            --font-family: "{{ $settings->font_name ?? 'Tajawal' }}", system-ui, -apple-system, Segoe UI, Aria !important;
        }

        * {
            font-family: var(--font-family) !important;
        }
    </style>

    <!-- Tailwind CSS -->
    <link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
    <style>
        body {
            background: #f3f4f6;
            padding: 50px 20px 20px;
        }

        .kt-card {
            border: none !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08) !important;
        }

        .rating-form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
        }

        .rating-header {
            margin-bottom: 10px;
        }

        .rating-header h2 {
            font-size: 20px;
            color: #333;
        }

        .rating-header p {
            color: #666;
            font-size: 16px;
        }

        .ticket-details {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .detail-row {
            display: flex;
            font-size: 14px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: #555;
            font-weight: 600;
            margin-inline-end: 5px;
        }

        .detail-value {
            color: #333;
        }

        .stars-label {
            color: #333;
            display: block;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .stars {
            gap: 10px;
            display: flex;
            font-size: 26px;
            justify-content: end;
        }

        .star {
            cursor: pointer;
            color: #ddd;
            user-select: none;
            transition: all 0.1s ease;
        }

        .star:hover,
        .star.active {
            color: #ffc107;
            transform: scale(1.1);
        }

        .comment-section {
            margin-bottom: 10px;
        }

        .comment-label {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .comment-input {
            width: 100%;
            min-height: 90px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            resize: vertical;
        }

        .comment-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .comment-hint {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .form-actions {}

        .btn-submit {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            color: #999;
            font-size: 12px;
            line-height: 1.6;
            border-top: 1px solid var(--color-gray-100);
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        @media (max-width: 600px) {
            .rating-form-container {
                margin: 20px auto;
                padding: 20px;
            }

            .rating-header h1 {
                font-size: 20px;
            }

            .stars {
                font-size: 36px;
                gap: 8px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-value {
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="kt-card bg-white text-gray-500" style="max-width: 550px; margin: auto; border-color: var(--color-gray-200);">
        <div class="p-4">
            <div class="rating-header">
                <h2 class="font-semibold">{{ __('main.how_rate_experience') }}</h2>
                <p>{{ __('main.help_improve_support') }}</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="ticket-details">
                <div class="detail-row">
                    <span class="detail-label">{{ __('main.ticket_number') ?? 'رقم التذكرة' }}:</span>
                    <span class="detail-value">#{{ $ticket->uuid }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('main.title') ?? 'العنوان' }}:</span>
                    <span class="detail-value">{{ $ticket->subject }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('main.client') ?? 'العميل' }}:</span>
                    <span class="detail-value">{{ $ticket->name }}</span>
                </div>
            </div>

            <form action="{{ route('tickets.store-rating', [$ticket->uuid, $ticket->token]) }}" method="POST" id="ratingForm">
                @csrf

                <!-- Stars Rating -->
                <div class="stars-container">
                    <label class="stars-label">{{ __('messages.how_many_stars') ?? 'كم نجمة تمنح هذه التذكرة؟' }}</label>
                    <div class="stars" id="starsContainer">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}" title="{{ $i }} نجوم">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="">
                </div>

                <!-- Comment Section -->
                <div class="comment-section">
                    <label class="comment-label">
                        {{ __('messages.write_comment') ?? 'اكتب تعليقًا' }}
                        <span style="color: #999; font-weight: 400;">({{ __('main.optional') ?? 'اختياري' }})</span>
                    </label>
                    <textarea name="comment" class="comment-input" placeholder="{{ __('messages.comment_placeholder') ?? 'اكتب ملاحظاتك عن التجربة...' }}">{{ old('comment') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="kt-btn kt-btn-outline-primary rounded-full font-semibold" id="submitBtn" disabled>
                        {{ __('main.submit_rating') ?? 'إرسال التقييم' }}
                    </button>
                </div>
            </form>

            <div class="footer-note">
                <p>{{ __('messages.rating_form_note') ?? 'هذا النموذج مخصص لتقييم تجربة الدعم الفني فقط.' }}<br>
                    {{ __('messages.rating_confirmation') ?? 'شكراً لتقيمك، هذا يساعدنا على تحسين الخدمة' }}</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');
            const submitBtn = document.getElementById('submitBtn');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.dataset.value;
                    ratingInput.value = rating;

                    // Update stars display
                    stars.forEach(s => {
                        if (s.dataset.value <= rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });

                    // Enable submit button
                    submitBtn.disabled = false;
                });

                // Hover effect
                star.addEventListener('mouseenter', function() {
                    const hoverRating = this.dataset.value;
                    stars.forEach(s => {
                        if (s.dataset.value <= hoverRating) {
                            s.style.color = '#ffc107';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });

            document.getElementById('starsContainer').addEventListener('mouseleave', function() {
                stars.forEach(s => {
                    if (s.classList.contains('active')) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });

            // Form submission
            document.getElementById('ratingForm').addEventListener('submit', function(e) {
                if (ratingInput.value === '') {
                    e.preventDefault();
                    alert('{{ __('messages.please_select_rating') ?? 'من فضلك اختر تقييم' }}');
                    return false;
                }
            });
        });
    </script>
</body>

</html>
