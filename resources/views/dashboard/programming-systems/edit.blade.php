@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.programming_system')]))
@section('page-title', '✏️ ' . __('main.edit_type', ['type' => __('main.programming_system')]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-6">
        <form method="POST" action="{{ route('dashboard.programming-systems.update', $programmingSystem->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4">
                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- English Tab Content -->
                <div class="language-content" data-lang="en">
                    <div class="grid gap-4">
                        <div>
                            <label for="name_en" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.name') }}
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_en" name="name_en"
                                value="{{ old('name_en', $programmingSystem->translations['en']['name'] ?? '') }}" placeholder="Enter name in English">
                            @error('name_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="keywords_en" class="kt-label">{{ __('main.keywords_en') }}</label>
                            <input type="text" name="keywords_en" id="keywords_en" class="kt-input h-fit tagify-container"
                                value="{{ old('keywords_en', is_array($programmingSystem->translations['en']['keywords'] ?? null) ? json_encode($programmingSystem->translations['en']['keywords']) : '') }}"
                                placeholder="word">
                            <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                            @error('keywords_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'content_en',
                                'value' => old('content_en', $programmingSystem->translations['en']['content'] ?? ''),
                                'placeholder' => 'Enter content in English',
                            ])
                        </div>
                    </div>
                </div>

                <!-- Arabic Tab Content -->
                <div class="language-content hidden" data-lang="ar">
                    <div class="grid gap-4">
                        <div>
                            <label for="name_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.name') }}
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_ar" name="name_ar"
                                value="{{ old('name_ar', $programmingSystem->translations['ar']['name'] ?? '') }}" placeholder="أدخل الاسم بالعربية">
                            @error('name_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="keywords_ar" class="kt-label">{{ __('main.keywords_ar') }}</label>
                            <input type="text" name="keywords_ar" id="keywords_ar" class="kt-input h-fit tagify-container"
                                value="{{ old('keywords_ar', is_array($programmingSystem->translations['ar']['keywords'] ?? null) ? json_encode($programmingSystem->translations['ar']['keywords']) : '') }}"
                                placeholder="كلمة">
                            <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                            @error('keywords_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'content_ar',
                                'value' => old('content_ar', $programmingSystem->translations['ar']['content'] ?? ''),
                                'placeholder' => 'أدخل المحتوى بالعربية',
                            ])
                        </div>
                    </div>
                </div>

                <!-- Icon -->
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.photo', ['label' => 'icon', 'column' => 'icon', 'record' => $programmingSystem])
                </div>

                <!-- Images -->
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.upload-file', ['label' => 'images', 'column' => 'images', 'record' => $programmingSystem])
                </div>

                <!-- Common Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.alt_text') }}</label>
                        <input type="text" name="alt_text" value="{{ old('alt_text', $programmingSystem->alt_text) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('alt_text') border-red-500 @enderror"
                            placeholder="{{ __('main.alt_text') }}">
                        @error('alt_text')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                        <input type="number" name="order" value="{{ old('order', $programmingSystem->order) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" min="0">
                    </div>
                </div>

                <!-- Checkboxes -->
                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('dashboard.components.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $programmingSystem->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                <!-- Update Button -->
                @include('dashboard.components.update-submit', ['models' => 'dashboard.programming-systems', 'model' => 'programming_system'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.drag-drop-images')

    <script script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tagify on Route Itinerary
            var inputs = document.querySelectorAll('.tagify-container');
            if (inputs) {
                inputs.forEach(input => {
                    new Tagify(input, {
                        maxTags: 20,
                        dropdown: {
                            maxItems: 20, // <- mixumum allowed rendered suggestions
                            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                            enabled: 0, // <- show suggestions on focus
                            closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                        }
                    });
                });
            }

            function initCkEditors() {
                if (window.CKEDITOR) {
                    document.querySelectorAll('textarea.ckeditor').forEach(function(el) {
                        if (el.id && CKEDITOR.instances[el.id]) {
                            CKEDITOR.instances[el.id].destroy(true);
                        }
                        if (!el.classList.contains('ckeditor-initialized')) {
                            CKEDITOR.replace(el.id, {
                                height: 300
                            });
                            el.classList.add('ckeditor-initialized');
                        }
                    });
                } else {
                    setTimeout(initCkEditors, 300);
                }
            }
            initCkEditors();
        });
    </script>
@endpush
