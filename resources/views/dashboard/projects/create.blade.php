@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.project')]))
@section('page-title', '🏢 ' . __('main.create_type', ['type' => __('main.project')]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- Arabic Tab Content -->
                <div class="language-content" data-lang="ar">
                    <div class="grid gap-4">
                        <div>
                            <label for="name_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_ar" name="name_ar" required
                                value="{{ old('name_ar') }}" placeholder="أدخل الاسم بالعربية">
                            @error('name_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="description_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description_ar') border-red-500 @enderror" id="description_ar"
                                name="description_ar" rows="5" placeholder="أدخل الوصف بالعربية">{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- English Tab Content -->
                <div class="language-content hidden" data-lang="en">
                    <div class="grid gap-4">
                        <div>
                            <label for="name_en" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_en" name="name_en"
                                value="{{ old('name_en') }}" placeholder="Enter name in English">
                            @error('name_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="description_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description_en') border-red-500 @enderror" id="description_en"
                                name="description_en" rows="5" placeholder="Enter description in English">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tag (Tagify) -->
                <div>
                    <label for="tags" class="kt-label">{{ __('main.tags') }}</label>
                    <input type="text" name="tags" id="tags" class="kt-input h-fit tagify-container" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3">
                    <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                    @error('tags')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Common Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.website') }}</label>
                        <input type="url" name="website" value="{{ old('website') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('website') border-red-500 @enderror"
                            placeholder="https://example.com">
                        @error('website')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            min="0">
                    </div>
                </div>

                <!-- Media & Other Fields -->
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.photo', ['column' => 'image'])
                </div>

                <!-- Checkboxes -->
                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('dashboard.components.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                <!-- Save Button -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.projects', 'model' => 'company'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.drag-drop-images')
    <script script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>

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
        });
    </script>
@endpush
