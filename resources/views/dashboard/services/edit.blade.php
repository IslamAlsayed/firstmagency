@extends('dashboard.layout.master')

@section('title', __('main.edit_service'))
@section('page-title', '💼 ' . __('main.edit_service'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_service') }}</h3>

            <a href="{{ route('dashboard.services.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.services')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.services.update', $service->id) ?? '#' }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4 lg:gap-6">
                    <!-- Tabs Navigation -->
                    @include('dashboard.components.tabs-navigation')

                    <!-- Arabic Tab Content -->
                    <div class="language-content" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title_ar') }}
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_ar"
                                    name="title_ar" required value="{{ old('title_ar', $service->translations['ar']['title'] ?? '') }}"
                                    placeholder="أدخل العنوان بالعربية">
                                @error('title_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- الوصف --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'description_ar',
                                    'value' => old('description_ar', $service->translations['ar']['description'] ?? ''),
                                    'placeholder' => 'أدخل الوصف بالعربية',
                                ])

                                {{-- المحتوى --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'content_ar',
                                    'value' => old('content_ar', $service->translations['ar']['content'] ?? ''),
                                    'placeholder' => 'أدخل المحتوى بالعربية',
                                ])
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- keywords Arabic (Tagify) -->
                                <div>
                                    <label for="keywords_ar" class="kt-label">{{ __('main.keywords_ar') }}</label>
                                    <input type="text" name="keywords_ar" id="keywords_ar" class="kt-input h-fit tagify-container"
                                        value="{{ old('keywords_ar', $service->translations['ar']['keywords'] ?? '') }}" placeholder="كلمة">
                                    <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                                    @error('keywords_ar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meta_description_ar"
                                        class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.meta_description_ar') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="meta_description_ar" name="meta_description_ar"
                                        value="{{ old('meta_description_ar', $service->translations['ar']['meta_description'] ?? '') }}" maxlength="300"
                                        placeholder="وصف الميتا بالعربية">
                                    @error('meta_description_ar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- English Tab Content -->
                    <div class="language-content hidden" data-lang="en">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title_en') }}</label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_en"
                                    name="title_en" value="{{ old('title_en', $service->translations['en']['title'] ?? '') }}"
                                    placeholder="Enter title in English">
                                @error('title_en')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- Description --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'description_en',
                                    'value' => old('description_en', $service->translations['en']['description'] ?? ''),
                                    'placeholder' => 'Enter description in English',
                                ])

                                {{-- Content --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'content_en',
                                    'value' => old('content_en', $service->translations['en']['content'] ?? ''),
                                    'placeholder' => 'Enter content in English',
                                ])
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- keywords English (Tagify) -->
                                <div>
                                    <label for="keywords_en" class="kt-label">{{ __('main.keywords_en') }}</label>
                                    <input type="text" name="keywords_en" id="keywords_en" class="kt-input h-fit tagify-container"
                                        value="{{ old('keywords_en', $service->translations['en']['keywords'] ?? '') }}" placeholder="word">
                                    <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                                    @error('keywords_en')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meta_description_en"
                                        class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.meta_description_en') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="meta_description_en" name="meta_description_en"
                                        value="{{ old('meta_description_en', $service->translations['en']['meta_description'] ?? '') }}" maxlength="300"
                                        placeholder="Meta description in English">
                                    @error('meta_description_en')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media & Other Fields -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['column' => 'icon'])
                        @include('dashboard.components.photo', ['column' => 'image'])
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                id="order" name="order" value="{{ old('order', $service->order) }}" min="0" placeholder="0">
                            @error('order')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
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
                                'checked' => $service->is_active,
                                'label' => __('main.active'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="featured" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'featured',
                                'id' => 'featured',
                                'value' => '1',
                                'checked' => $service->featured,
                                'label' => __('main.featured'),
                            ])
                        </div>
                    </div>

                    <!-- Update Button -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.services', 'model' => 'service'])
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Tagify on Route Itinerary
            var inputs = document.querySelectorAll('.tagify-container');
            if (inputs) {
                inputs.forEach(input => {
                    new Tagify(input, {
                        maxTags: 20,
                        dropdown: {
                            maxItems: 20,
                            classname: "tags-look",
                            enabled: 0,
                            closeOnSelect: false
                        }
                    });
                });
            }
        });
    </script>
@endpush
