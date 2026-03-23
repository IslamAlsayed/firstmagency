<style>
    .layout {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;

        &,
        & * {
            z-index: 150450;
        }

        &.hidden {
            display: none;
        }

        #reviewForm {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 90%;
            max-width: 600px;
            max-height: 90svh;
            overflow-y: scroll;

            &::-webkit-scrollbar {
                width: 4px;
            }

            &::-webkit-scrollbar-thumb {
                border-radius: 4px;
                background-color: var(--color-gray-400);
            }
        }
    }
</style>

<section class="section reviews-section relative">
    <div class="text-center title font-semibold">{{ __('main.reviews_title') }} <span class="title-badge">{{ __('main.reviews_subtitle') }}</span></div>
    <div class="text-center description">{{ __('main.reviews_description') }}</div>

    <div class="our-review-review-wrapper">
        <div class="relative mb-4">
            <div class="review-title">{{ __('main.reviews_title_review') }}</div>
            @if ($reviews && count($reviews) > 0)
                <div class="wrapper-actions">
                    <div class="action">
                        <div class="swiper-button-next"></div>
                    </div>
                    <div class="action">
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            @endif
        </div>
        <div class="our-reviews-wrapper">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="15" slides-per-view="3" navigation="true" navigation-next-el=".swiper-button-next"
                navigation-prev-el=".swiper-button-prev"
                breakpoints='{"320": {"slidesPerView": 1, "spaceBetween": 10}, "640": {"slidesPerView": 2, "spaceBetween": 15}, "1024": {"slidesPerView": 3, "spaceBetween": 15}, "1400": {"slidesPerView": 4, "spaceBetween": 15}}'>
                @if ($reviews && count($reviews) > 0)
                    @foreach ($reviews as $review)
                        <swiper-slide class="review">
                            <div class="info flex items-center gap-2">
                                <div class="review-photo">
                                    @if ($review->photo)
                                        <img src="{{ asset('storage/' . $review->photo) }}" alt="{{ $review->name }}" loading="lazy">
                                    @else
                                        <img src="{{ asset('assets/images/placeholder.png') }}" alt="{{ $review->name }}">
                                    @endif
                                </div>
                                <div class="review-info">
                                    <div class="review-name font-semibold">{{ $review->name }}</div>
                                    <div class="review-country">{{ $review->country }}</div>
                                    <div class="review-review">
                                        @for ($i = 1; $i <= $review->rate; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="comment mt-4">{{ $review->comment }}</div>
                            <div class="voice mt-4">
                                @if ($review->audio)
                                    <audio controls style="width: 100%; height: 30px;">
                                        <source src="{{ asset('storage/' . $review->audio) }}" type="audio/mpeg">
                                        {{ __('main.audio_not_supported') }}
                                    </audio>
                                @else
                                    {{ __('main.reviews_no_voice') }}
                                @endif
                            </div>
                        </swiper-slide>
                    @endforeach
                @else
                    <div class="text-center py-8 w-full">
                        <p class="text-gray-500">{{ __('messages.no_reviews_yet') }}</p>
                    </div>
                @endif
            </swiper-container>
        </div>

        <div class="review-form text-center">
            <button class="btn-link primary-color flex items-center justify-center gap-2 font-semibold" toggle-button id="writeReviewBtn">
                <i class="fas fa-plus icon-plus"></i>
                {{ __('main.write_review') }}
            </button>
        </div>
    </div>

    <div class="layout hidden" id="reviewFormLayout">
        <form id="reviewForm" class="mt-8 mx-auto bg-white rounded-[9px] shadow-lg p-6 border border-gray-200" enctype="multipart/form-data">
            <!-- Close Button -->
            <button type="button" id="closeReviewBtn" class="absolute cursor-pointer text-red-600 hover:text-red-800 transition"
                style="top: 10px; {{ app()->getLocale() == 'ar' ? 'left: 10px' : 'right: 10px' }}">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="grid grid-cols-1 lg:grid-cols-3 items-end gap-4">
                <!-- Name Field -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-600 text-start mb-2">
                        <i class="fas fa-user text-primary me-2"></i>{{ __('main.your_name') ?? 'اسمك' }}
                    </label>
                    <input type="text" name="name" placeholder="{{ __('main.enter_your_name') ?? 'أدخل اسمك الكامل' }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition placeholder-gray-400">
                </div>

                <!-- Rating Field -->
                <div class="mb-5">
                    <label for="stars" class="kt-label mb-2 w-full">{{ __('main.rating') ?? 'تقييمك' }}</label>
                    <select name="stars" id="stars" class="kt-select h-[45px] bg-white" required>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('stars') == $i ? 'selected' : '' }} style="font-size: 12px;">
                                @for ($j = 1; $j <= $i; $j++)
                                    ⭐
                                @endfor
                                @for ($j = $i + 1; $j <= 5; $j++)
                                    ☆
                                @endfor
                            </option>
                        @endfor
                    </select>
                    @error('stars')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Country Field -->
                <div class="mb-5">
                    <label for="country" class="kt-label mb-2 w-full">{{ __('main.country') ?? 'دولتك' }}</label>
                    <select name="country" id="country" class="kt-select h-[45px] bg-white" required>
                        <option value="" disabled selected>{{ __('main.enter_your_country') ?? 'أدخل دولتك' }}</option>
                        <option value="EG" {{ old('country') == 'EG' ? 'selected' : '' }}>🇪🇬 مصر</option>
                        <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>🇸🇦 السعودية</option>
                        <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>🇦🇪 الإمارات</option>
                        <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>🇰🇼 الكويت</option>
                        <option value="IQ" {{ old('country') == 'IQ' ? 'selected' : '' }}>🇮🇶 العراق</option>
                        <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>🇶🇦 قطر</option>
                        <option value="SD" {{ old('country') == 'SD' ? 'selected' : '' }}>🇸🇩 السودان</option>
                        <option value="JO" {{ old('country') == 'JO' ? 'selected' : '' }}>🇯🇴 الأردن</option>
                        <option value="DZ" {{ old('country') == 'DZ' ? 'selected' : '' }}>🇩🇿 الجزائر</option>
                        <option value="MA" {{ old('country') == 'MA' ? 'selected' : '' }}>🇲🇦 المغرب</option>
                    </select>
                    @error('country')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Review Message Field -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-600 text-start mb-2">
                    <i class="fas fa-comment text-primary me-2"></i>{{ __('main.review_message') ?? 'رسالتك' }}
                </label>
                <textarea name="comment" placeholder="{{ __('main.write_your_review') ?? 'شارك آرائك وتجربتك...' }}" required rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition placeholder-gray-400 resize-none"></textarea>
            </div>

            <!-- Photo Upload Field -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-600 text-start mb-2">
                    <i class="fas fa-image text-primary me-2"></i>{{ __('main.photo') ?? 'صورة' }}
                    <span class="text-gray-500 font-normal">({{ __('main.optional') ?? 'اختياري' }})</span>
                </label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition cursor-pointer" id="photoUploadArea">
                    <i class="fas fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">{{ __('main.click_or_drag') ?? 'اضغط أو اسحب الصورة هنا' }}</p>
                    <input type="file" name="photo" accept="image/*" class="hidden" id="photoInput">
                    <div id="photoPreview" class="w-[80px] h-auto mt-3 hidden">
                        <img id="photoPreviewImg" src="" alt="Preview" class="max-h-40 mx-auto rounded-lg">
                        <button type="button" id="removephoto" class="kt-btn bg-danger cursor-pointer mt-2 text-sm">
                            <i class="fas fa-trash mr-1"></i>{{ __('main.remove') ?? 'إزالة' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Audio Section with Tabs -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-600 text-start">
                    <i class="fas fa-microphone text-primary me-2"></i>{{ __('main.audio_record') ?? 'تسجيل صوتي' }}
                    <span class="text-gray-500 font-normal">({{ __('main.optional') ?? 'اختياري' }})</span>
                </label>

                <!-- Tab Buttons -->
                <div class="flex gap-2 mb-4 border-b-2 border-gray-200">
                    <button type="button" id="audioUploadTab" class="audio-tab-btn px-4 py-2 font-semibold text-primary border-b-2 border-b-primary transition hover:opacity-80 active"
                        data-tab="upload">
                        <i class="fas fa-cloud-arrow-up me-2"></i>{{ __('main.upload_audio') ?? 'رفع ملف صوتي' }}
                    </button>
                    <button type="button" id="audioRecordTab" class="audio-tab-btn px-4 py-2 font-semibold text-gray-600 border-b-2 border-transparent transition hover:text-primary"
                        data-tab="record">
                        <i class="fas fa-microphone me-2"></i>{{ __('main.record_now') ?? 'سجل الآن' }}
                    </button>
                </div>

                <!-- Upload Audio Tab -->
                <div id="audioUploadContent" class="audio-tab-content">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition cursor-pointer" id="audioUploadArea">
                        <i class="fas fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">{{ __('main.click_or_drag_audio') ?? 'اضغط أو اسحب الملف الصوتي هنا' }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ __('main.supported_formats') ?? 'الصيغ المدعومة: MP3, WAV, M4A' }}</p>
                        <input type="file" name="audio_upload" accept="audio/*" class="hidden" id="audioUploadInput">
                        <div id="audioUploadPreview" class="mt-4 hidden">
                            <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span id="audioUploadFileName" class="text-sm text-gray-700 font-medium"></span>
                                </div>
                                <button type="button" id="removeAudioUpload" class="kt-btn bg-danger cursor-pointer transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <audio id="audioUploadPlayer" controls class="w-full mt-3 rounded-lg">
                                {{ __('main.audio_not_supported') ?? 'متصفحك لا يدعم تشغيل الصوت' }}
                            </audio>
                        </div>
                    </div>
                </div>

                <!-- Record Audio Tab -->
                <div id="audioRecordContent" class="audio-tab-content hidden">
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <button type="button" id="startRecordBtn"
                                class="w-[200px] px-4 py-3 bg-primary hover:bg-dark-primary cursor-pointer text-white rounded-lg transition font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-circle text-red-500 animate-pulse"></i> {{ __('main.start_recording') ?? 'ابدأ التسجيل' }}
                            </button>
                            <button type="button" id="stopRecordBtn"
                                class="w-[200px] px-4 py-3 bg-gray-400 cursor-pointer text-white rounded-lg hover:bg-gray-500 transition font-semibold flex items-center justify-center gap-2 hidden"
                                disabled>
                                <i class="fas fa-square text-white"></i> {{ __('main.stop_recording') ?? 'إيقاف التسجيل' }}
                            </button>
                        </div>

                        <div id="recordingStatus" class="text-sm text-gray-600 hidden flex items-center gap-2">
                            <i class="fas fa-microphone text-red-600 animate-pulse"></i>
                            {{ __('main.recording') ?? 'جاري التسجيل...' }}
                            <span id="recordingTime" class="font-mono font-bold">00:00</span>
                        </div>

                        <div id="recordingPreview" class="hidden flex flex-row-reverse justify-end gap-4">
                            <div class="w-[300px] flex items-center justify-between gap-4 bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-blue-600"></i>
                                    <span class="text-sm text-gray-700 font-medium">{{ __('main.recording_completed') ?? 'تم التسجيل بنجاح' }}</span>
                                </div>
                                <button type="button" id="removeRecording" class="kt-btn bg-danger cursor-pointer transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <audio id="audioRecordPlayer" controls class="w-[200px] rounded-lg">
                                {{ __('main.audio_not_supported') ?? 'متصفحك لا يدعم تشغيل الصوت' }}
                            </audio>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for form submission -->
                <input type="hidden" name="audio" id="audioInput">
            </div>

            <!-- Submit Button -->
            <div class="flex flex-row-reverse items-center justify-between gap-3">
                <p>{{ __('main.review_will_be_checked') ?? 'سيتم مراجعة الرأي قبل نشره.' }}</p>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 p-3 bg-primary hover:bg-dark-primary text-white text-nowrap cursor-pointer rounded-lg transition font-semibold flex items-center justify-center gap-2 shadow-md">
                        <i class="fas fa-paper-plane"></i> {{ __('main.send_review') ?? 'إرسال المراجعة' }}
                    </button>
                    <button type="button" id="cancelReviewBtn" class="flex-1 p-3 bg-gray-300 text-gray-700  text-nowrap cursor-pointer rounded-lg hover:bg-gray-400 transition font-semibold">
                        {{ __('main.cancel') ?? 'إلغاء' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-reviews</div>
    @endif
</section>

@push('scripts')
    <script>
        // Form visibility toggle
        const writeReviewBtn = document.getElementById('writeReviewBtn');
        const reviewFormLayout = document.getElementById('reviewFormLayout');
        const reviewForm = document.getElementById('reviewForm');
        const closeReviewBtn = document.getElementById('closeReviewBtn');
        const cancelReviewBtn = document.getElementById('cancelReviewBtn');
        const sections = [
            document.querySelector('.header'),
            document.querySelector('.fixed-support'),
            ...document.querySelectorAll('.section:not(.reviews-section)')
        ];

        writeReviewBtn.addEventListener('click', () => {
            sections.forEach(s => s.classList.add('blur'));
            reviewFormLayout.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            reviewFormLayout.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });

        // hide form when clicking outside of it
        document.addEventListener('click', (e) => {
            if (!reviewFormLayout.classList.contains('hidden') && !reviewForm.contains(e.target) && e.target !== writeReviewBtn) {
                hideForm();
            }
        });

        closeReviewBtn?.addEventListener('click', hideForm);
        cancelReviewBtn?.addEventListener('click', hideForm);

        function hideForm() {
            reviewFormLayout.classList.add('hidden');
            document.body.style.overflow = 'auto';
            sections.forEach(s => s.classList.remove('blur'));
            reviewForm.reset();
            resetForm();
        }

        // Star Rating from Select Dropdown
        const starsSelect = document.getElementById('stars');
        let selectedRating = 0;

        starsSelect.addEventListener('change', () => {
            selectedRating = parseInt(starsSelect.value) || 0;
            console.log('تم اختيار التقييم:', selectedRating);
        });

        // Photo Upload
        const photoUploadArea = document.getElementById('photoUploadArea');
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPreviewImg = document.getElementById('photoPreviewImg');
        const removePhotoBtn = document.getElementById('removephoto');

        photoUploadArea.addEventListener('click', () => photoInput.click());

        photoUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            photoUploadArea.classList.add('border-primary', 'bg-primary/5');
        });

        photoUploadArea.addEventListener('dragleave', () => {
            photoUploadArea.classList.remove('border-primary', 'bg-primary/5');
        });

        photoUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            photoUploadArea.classList.remove('border-primary', 'bg-primary/5');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                photoInput.files = files;
                handlePhotoSelect();
            }
        });

        photoInput.addEventListener('change', handlePhotoSelect);

        function handlePhotoSelect() {
            const file = photoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    photoPreviewImg.src = e.target.result;
                    photoPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        removePhotoBtn?.addEventListener('click', () => {
            photoInput.value = '';
            photoPreview.classList.add('hidden');
        });

        // Audio Tabs Switching
        const audioTabBtns = document.querySelectorAll('.audio-tab-btn');
        const audioTabContents = document.querySelectorAll('.audio-tab-content');

        audioTabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tabName = btn.getAttribute('data-tab');

                // Remove active state from all tabs
                audioTabBtns.forEach(b => {
                    b.classList.remove('active', 'border-b-primary', 'text-primary');
                });

                // Hide all tab contents
                audioTabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Activate clicked tab
                btn.classList.add('active', 'border-b-primary', 'text-primary');

                // Show selected content
                if (tabName === 'upload') {
                    document.getElementById('audioUploadContent').classList.remove('hidden');
                } else if (tabName === 'record') {
                    document.getElementById('audioRecordContent').classList.remove('hidden');
                }
            });
        });

        // Audio Upload
        const audioUploadArea = document.getElementById('audioUploadArea');
        const audioUploadInput = document.getElementById('audioUploadInput');
        const audioUploadPreview = document.getElementById('audioUploadPreview');
        const audioUploadPlayer = document.getElementById('audioUploadPlayer');
        const removeAudioUploadBtn = document.getElementById('removeAudioUpload');
        const audioUploadFileName = document.getElementById('audioUploadFileName');

        audioUploadArea.addEventListener('click', () => audioUploadInput.click());

        audioUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            audioUploadArea.classList.add('border-primary', 'bg-primary/5');
        });

        audioUploadArea.addEventListener('dragleave', () => {
            audioUploadArea.classList.remove('border-primary', 'bg-primary/5');
        });

        audioUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            audioUploadArea.classList.remove('border-primary', 'bg-primary/5');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                audioUploadInput.files = files;
                handleAudioUpload();
            }
        });

        audioUploadInput.addEventListener('change', handleAudioUpload);

        function handleAudioUpload() {
            const file = audioUploadInput.files[0];
            if (file) {
                audioUploadFileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    audioUploadPlayer.src = e.target.result;
                    audioInput.value = e.target.result;
                    audioUploadPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        removeAudioUploadBtn?.addEventListener('click', () => {
            audioUploadInput.value = '';
            audioUploadPreview.classList.add('hidden');
            audioInput.value = '';
        });

        // Audio Recording
        let mediaRecorder;
        let audioChunks = [];
        let recordingStartTime;
        let recordingInterval;

        const startRecordBtn = document.getElementById('startRecordBtn');
        const stopRecordBtn = document.getElementById('stopRecordBtn');
        const recordingStatus = document.getElementById('recordingStatus');
        const recordingTime = document.getElementById('recordingTime');
        const recordingPreview = document.getElementById('recordingPreview');
        const audioRecordPlayer = document.getElementById('audioRecordPlayer');
        const removeRecordingBtn = document.getElementById('removeRecording');

        startRecordBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.addEventListener('dataavailable', (event) => {
                    audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener('stop', () => {
                    const audioBlob = new Blob(audioChunks, {
                        type: 'audio/wav'
                    });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioRecordPlayer.src = audioUrl;
                    recordingPreview.classList.remove('hidden');

                    // Convert blob to base64 for form submission
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        audioInput.value = reader.result;
                    };
                    reader.readAsDataURL(audioBlob);

                    stopRecording();
                });

                mediaRecorder.start();
                startRecordBtn.disabled = true;
                startRecordBtn.classList.add('hidden');
                stopRecordBtn.disabled = false;
                stopRecordBtn.classList.remove('hidden');
                recordingStatus.classList.remove('hidden');
                recordingStartTime = Date.now();

                recordingInterval = setInterval(() => {
                    const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
                    const minutes = Math.floor(elapsed / 60);
                    const seconds = elapsed % 60;
                    recordingTime.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }, 1000);
            } catch (err) {
                window.showToast({
                    type: 'info',
                    message: '{{ __('main.microphone_permission') ?? 'يرجى السماح باستخدام الميكروفون' }}',
                });
            }
        });

        stopRecordBtn.addEventListener('click', () => {
            if (mediaRecorder) {
                mediaRecorder.stop();
            }
        });

        function stopRecording() {
            startRecordBtn.disabled = false;
            startRecordBtn.classList.remove('hidden');
            stopRecordBtn.disabled = true;
            stopRecordBtn.classList.add('hidden');
            recordingStatus.classList.add('hidden');
            clearInterval(recordingInterval);
        }

        removeRecordingBtn?.addEventListener('click', () => {
            recordingPreview.classList.add('hidden');
            audioInput.value = '';
            audioRecordPlayer.src = '';
            startRecordBtn.disabled = false;
            startRecordBtn.classList.remove('hidden');
            stopRecordBtn.classList.add('hidden');
        });

        function resetForm() {
            selectedRating = 0;
            starsSelect.value = '';
            photoInput.value = '';
            photoPreview.classList.add('hidden');

            // Reset audio upload
            audioUploadInput.value = '';
            audioUploadPreview.classList.add('hidden');
            audioUploadPlayer.src = '';

            // Reset audio recording
            recordingPreview.classList.add('hidden');
            audioRecordPlayer.src = '';
            audioInput.value = '';
            startRecordBtn.disabled = false;
            startRecordBtn.classList.remove('hidden');
            stopRecordBtn.disabled = true;
            stopRecordBtn.classList.add('hidden');
        }

        // Form Submission with jQuery AJAX
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedRating === 0) {
                window.showToast({
                    type: 'info',
                    message: '{{ __('main.rating') ?? 'يرجى اختيار التقييم' }}',
                });
                return;
            }

            const formData = new FormData(reviewForm);
            formData.append('rate', selectedRating);

            // Add photo only if selected
            if (photoInput.files && photoInput.files.length > 0) {
                formData.set('photo', photoInput.files[0]);
            } else {
                formData.delete('photo');
            }

            $.ajax({
                url: '{{ route('api.reviews.store') }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    console.log('جاري الإرسال...');
                },
                success: function(response) {
                    window.showToast({
                        type: response.status ?? 'success',
                        message: response.message ?? 'تم إرسال المراجعة بنجاح!',
                    });
                    hideForm();
                    // Uncomment to reload: location.reload();
                },
                error: function(xhr, status, error) {
                    window.showToast({
                        type: xhr.status ?? 'error',
                        message: xhr.responseText ?? 'حدث خطأ عند إرسال المراجعة',
                    });
                },
                complete: function() {
                    console.log('انتهى الطلب');
                }
            });
        });
    </script>
@endpush
