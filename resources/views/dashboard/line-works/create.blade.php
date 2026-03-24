@extends('dashboard.layout.master')

@section('title', __('main.create_line_work'))
@section('page-title', '⚙️ ' . __('main.create_line_work'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_line_work') }}</h3>

            <a href="{{ route('dashboard.line-works.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                {{ __('main.back_to_types', ['types' => __('main.line_works')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.line-works.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4">
                    <!-- Tabs Navigation -->
                    @include('dashboard.components.tabs-navigation')

                    <!-- English Tab Content -->
                    <div class="language-content" data-lang="en">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_en" name="title_en"
                                    value="{{ old('title_en') }}" placeholder="Enter title in English">
                                @error('title_en')
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

                    <!-- Arabic Tab Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_ar" name="title_ar"
                                    required value="{{ old('title_ar') }}" placeholder="أدخل العنوان بالعربية">
                                @error('title_ar')
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

                    <!-- Common Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.alt_text') }}</label>
                            <input type="text" name="alt_text" value="{{ old('alt_text') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('alt_text') border-red-500 @enderror"
                                placeholder="{{ __('main.alt_text') }}">
                            @error('alt_text')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                            <input type="number" name="order" value="{{ old('order', 0) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" min="0">
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
                                'checked' => 0,
                                'label' => __('main.active'),
                            ])
                        </div>
                    </div>

                    <!-- Save Button -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.line-works', 'model' => 'line_work'])
                </div>
            </form>
        </div>
    </div>
@endsection
