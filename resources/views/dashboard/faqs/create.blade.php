@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.faq')]))
@section('page-title', '❓ ' . __('main.create_type', ['type' => __('main.faq')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_type', ['type' => __('main.faq')]) }}</h3>

            <a href="{{ route('dashboard.faqs.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.faqs')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.faqs.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 lg:gap-6">
                    <!-- Category -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.category') }} <span
                                    class="text-red-500">*</span></label>
                            <select class="kt-select basic-single" id="category" name="category" required>
                                <option value="">{{ __('main.select_category') }}</option>
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                            <input type="number" class="w-full h-[45px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1" id="order"
                                name="order" value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    @include('dashboard.components.tabs-navigation')

                    <!-- English Tab Content -->
                    <div class="language-content" data-lang="en">
                        <div class="grid gap-4">
                            <div>
                                <label for="question" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.question') }} (EN) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1" id="question"
                                    name="question" required value="{{ old('question') }}" placeholder="Enter question in English">
                                @error('question')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            @include('dashboard.components.input-text-editor', [
                                'name' => 'answer',
                                'value' => old('answer'),
                                'placeholder' => 'Enter answer in English',
                            ])
                        </div>
                    </div>

                    <!-- Arabic Tab Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <label for="question_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.question') }} (AR) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1" id="question_ar"
                                    name="question_ar" required value="{{ old('question_ar') }}" placeholder="أدخل السؤال بالعربية">
                                @error('question_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            @include('dashboard.components.input-text-editor', [
                                'name' => 'answer_ar',
                                'value' => old('answer_ar'),
                                'placeholder' => 'أدخل الإجابة بالعربية',
                            ])
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
                                'checked' => 0,
                                'label' => __('main.active'),
                            ])
                        </div>
                    </div>

                    <!-- Save Button -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.faqs', 'model' => 'faq'])
                </div>
            </form>
        </div>
    </div>
@endsection
