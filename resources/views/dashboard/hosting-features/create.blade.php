@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.hosting_feature')]))
@section('page-title', '🎁 ' . __('main.create_type', ['type' => __('main.hosting_feature')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_type', ['type' => __('main.hosting_feature')]) }}</h3>

            <a href="{{ route('dashboard.hosting-features.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                {{ __('main.back_to_types', ['types' => __('main.hosting_features')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.hosting-features.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6">
                    <!-- Tabs Navigation -->
                    @include('dashboard.components.tabs-navigation')

                    <!-- English Tab Content -->
                    <div class="language-content" data-lang="en">
                        <div class="grid gap-6">
                            <!-- Title English -->
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title_en') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title_en" name="title_en" value="{{ old('title_en') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('title_en') border-red-500 @enderror"
                                    placeholder="Enter title in English">
                                @error('title_en')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description English -->
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'description_en',
                                'value' => old('description_en'),
                                'placeholder' => 'Enter description in English',
                            ])
                        </div>
                    </div>

                    <!-- Arabic Tab Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="grid gap-6">
                            <!-- Title Arabic -->
                            <div>
                                <label for="title_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title_ar') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar') }}"
                                    class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('title_ar') border-red-500 @enderror"
                                    placeholder="أدخل العنوان بالعربية">
                                @error('title_ar')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Arabic -->
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'description_ar',
                                'value' => old('description_ar'),
                                'placeholder' => 'أدخل الوصف بالعربية',
                            ])
                        </div>
                    </div>

                    <!-- معلومات الوسائط -->
                    @include('dashboard.components.photo', ['column' => 'image'])

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-600 mb-1">
                            {{ __('main.order') }}
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                    </div>

                    <!-- Save Button -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.hosting-features', 'model' => 'hosting-features'])
                </div>
            </form>
        </div>
    </div>
@endsection
