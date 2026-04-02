@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.review')]))
@section('page-title', '⭐ ' . __('main.create_type', ['type' => __('main.review')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form action="{{ route('dashboard.reviews.store') }}" method="POST" enctype="multipart/form-data" id="reviewForm">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information Card -->
                <div class="shadow-md radius-lg">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.name') }}
                                    <span class="text-red-500 font-bold">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition @error('name') border-red-500 @enderror"
                                    placeholder="{{ __('main.enter', ['field' => __('main.name')]) }}" required>
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.country') }}
                                    <span class="text-red-500 font-bold">*</span>
                                </label>
                                <select id="country" name="country"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition @error('country') border-red-500 @enderror"
                                    required>
                                    <option value="">{{ __('main.select', ['field' => __('main.country')]) }}</option>
                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>🇸🇦 Saudi Arabia</option>
                                    <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>🇦🇪 United Arab Emirates</option>
                                    <option value="EG" {{ old('country') == 'EG' ? 'selected' : '' }}>🇪🇬 Egypt</option>
                                    <option value="KW" {{ old('country') == 'KW' ? 'selected' : '' }}>🇰🇼 Kuwait</option>
                                    <option value="QA" {{ old('country') == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                                    <option value="BH" {{ old('country') == 'BH' ? 'selected' : '' }}>🇧🇭 Bahrain</option>
                                    <option value="OM" {{ old('country') == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                                    <option value="JO" {{ old('country') == 'JO' ? 'selected' : '' }}>🇯🇴 Jordan</option>
                                    <option value="LB" {{ old('country') == 'LB' ? 'selected' : '' }}>🇱🇧 Lebanon</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>🇺🇸 United States</option>
                                </select>
                                @error('country')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div>
                                <label for="rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.rating') }}
                                    <span class="text-red-500 font-bold">*</span>
                                </label>
                                <select id="rate" name="rate"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition @error('rate') border-red-500 @enderror"
                                    required>
                                    <option value="">{{ __('main.select', ['field' => __('main.rating')]) }}</option>
                                    <option value="5" {{ old('rate', 5) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ {{ __('main.excellent') }}</option>
                                    <option value="4" {{ old('rate') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ {{ __('main.good') }}</option>
                                    <option value="3" {{ old('rate') == 3 ? 'selected' : '' }}>⭐⭐⭐ {{ __('main.fair') }}</option>
                                    <option value="2" {{ old('rate') == 2 ? 'selected' : '' }}>⭐⭐ {{ __('main.poor') }}</option>
                                    <option value="1" {{ old('rate') == 1 ? 'selected' : '' }}>⭐ {{ __('main.very_poor') }}</option>
                                </select>
                                @error('rate')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Content Card -->
                <div class="shadow-md radius-lg">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.content') }}</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <!-- Comment/Message -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('main.message') }}
                                <span class="text-red-500 font-bold">*</span>
                            </label>
                            <textarea id="comment" name="comment" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition @error('comment') border-red-500 @enderror"
                                placeholder="{{ __('main.enter', ['field' => __('main.message')]) }}" required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">{{ __('main.word_count') }}: <span id="wordCount">0</span> / 500</p>
                        </div>
                    </div>
                </div>

                <!-- Media Card -->
                <div class="shadow-md radius-lg">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.media') }}</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Photo Upload -->
                            @include('dashboard.components.photo')

                            <!-- Audio Upload/Record -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('main.audio') }}
                                </label>

                                <!-- Tabs for Audio Upload and Recording -->
                                <div class="flex gap-2 mb-3">
                                    <button type="button" class="audio-tab cursor-pointer px-4 py-2 border-custom-b-2 border-custom-color font-medium" data-tab="upload">
                                        📁 {{ __('main.upload') }}
                                    </button>
                                    <button type="button" class="audio-tab cursor-pointer px-4 py-2 text-gray-600" data-tab="record">
                                        🎤 {{ __('main.record') }}
                                    </button>
                                </div>

                                <!-- Upload Tab -->
                                <div id="audioUploadTab" class="audio-content">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition" id="audioDropZone">
                                        <input type="file" id="audioFile" name="audioFile" accept="audio/*" class="hidden">
                                        <i class="ki-filled ki-file-up text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-600 text-sm">{{ __('main.click_or_drag_audio') }}</p>
                                        <span id="audioFileName" class="text-xs text-gray-500 mt-1 block"></span>
                                    </div>
                                </div>

                                <!-- Record Tab -->
                                <div id="audioRecordTab" class="audio-content hidden">
                                    <div class="">
                                        <div id="recorder" class="flex gap-2 items-center justify-start">
                                            <button type="button" id="startRecording" class="kt-btn kt-btn-success">
                                                🎙️ {{ __('main.start_recording') }}
                                            </button>
                                            <button type="button" id="stopRecording" class="kt-btn kt-btn-danger hidden">
                                                ⏹️ {{ __('main.stop_recording') }}
                                            </button>
                                        </div>
                                        <div id="audioPlayback" style="display: none;" class="mt-3">
                                            <audio id="audioPreview" controls class="w-[300px]" style="border: 1px solid #cacacc; border-radius: 50px;"></audio>
                                            <button type="button" id="removeAudio" class="kt-btn bg-danger mt-2 text-sm">{{ __('main.remove') }}</button>
                                        </div>
                                    </div>

                                    <div id="recordingTimer" class="mt-3 hidden">
                                        <div class="text-sm text-gray-600">
                                            ⏱️ {{ __('main.recording_time') ?? 'وقت التسجيل' }}: <span id="timerDisplay" class="font-mono">00:00</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden audio data input -->
                                <input type="hidden" id="audio" name="audio">
                                @error('audio')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.reviews', 'model' => 'review'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.drag-drop-images')
    <script src="https://cdn.jsdelivr.net/npm/wavesurfer.js@6.0.0/dist/wavesurfer.js"></script>
    <script>
        // Audio Tab Switcher
        document.querySelectorAll('.audio-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.audio-tab').forEach(t => t.classList.remove('border-custom-b-2', 'border-custom-color'));
                tab.classList.add('border-custom-b-2', 'border-custom-color');

                const tabName = tab.getAttribute('data-tab');
                document.querySelectorAll('.audio-content').forEach(content => content.classList.add('hidden'));
                document.getElementById('audio' + tabName.charAt(0).toUpperCase() + tabName.slice(1) + 'Tab').classList.remove('hidden');
            });
        });

        // Audio File Upload Handler
        const audioDropZone = document.getElementById('audioDropZone');
        const audioFile = document.getElementById('audioFile');
        const audioInput = document.getElementById('audio');
        const audioFileName = document.getElementById('audioFileName');

        audioDropZone.addEventListener('click', () => audioFile.click());
        audioDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            audioDropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });
        audioDropZone.addEventListener('dragleave', () => {
            audioDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
        audioDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            audioDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            const files = e.dataTransfer.files;
            if (files.length) audioFile.files = files;
            handleAudioSelect();
        });

        audioFile.addEventListener('change', handleAudioSelect);

        function handleAudioSelect() {
            if (audioFile.files.length) {
                const file = audioFile.files[0];
                audioFileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    audioInput.value = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Audio Recording Handler
        let mediaRecorder;
        let audioChunks = [];
        let recordingStartTime;
        let recordingInterval;
        const startBtn = document.getElementById('startRecording');
        const stopBtn = document.getElementById('stopRecording');
        const audioPlayback = document.getElementById('audioPlayback');
        const audioPreview = document.getElementById('audioPreview');
        const removeAudioBtn = document.getElementById('removeAudio');
        const recordingTimer = document.getElementById('recordingTimer');
        const timerDisplay = document.getElementById('timerDisplay');

        startBtn.addEventListener('click', async () => {
            audioChunks = [];
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();
            startBtn.classList.add('hidden');
            stopBtn.classList.remove('hidden');
            recordingTimer.classList.remove('hidden');

            recordingStartTime = Date.now();
            recordingInterval = setInterval(() => {
                const elapsed = Math.floor((Date.now() - recordingStartTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                timerDisplay.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }, 100);
        });

        stopBtn.addEventListener('click', () => {
            mediaRecorder.stop();
            mediaRecorder.ondataavailable = (e) => {
                audioChunks.push(e.data);
            };
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, {
                    type: 'audio/wav'
                });
                const reader = new FileReader();
                reader.onload = (e) => {
                    audioInput.value = e.target.result;
                    audioPreview.src = e.target.result;
                    audioPlayback.style.display = 'block';
                };
                reader.readAsDataURL(audioBlob);
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');
                recordingTimer.classList.add('hidden');
                clearInterval(recordingInterval);
                timerDisplay.textContent = '00:00';
            };
        });

        removeAudioBtn.addEventListener('click', () => {
            audioInput.value = '';
            audioFile.value = '';
            audioFileName.textContent = '';
            audioPlayback.style.display = 'none';
            recordingTimer.classList.add('hidden');
            timerDisplay.textContent = '00:00';
            clearInterval(recordingInterval);
        });

        // Word Counter for Comment
        document.getElementById('comment').addEventListener('input', function() {
            const words = this.value.trim().split(/\s+/).filter(w => w.length > 0).length;
            document.getElementById('wordCount').textContent = words;
        });
    </script>
@endpush
