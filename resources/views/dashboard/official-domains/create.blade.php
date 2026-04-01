@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.official_domain')]))
@section('page-title', '🌐 ' . __('main.create_type', ['type' => __('main.official_domain')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.official-domains.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-600 mb-1">
                        {{ __('main.title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title" name="title"
                        value="{{ old('title') }}" placeholder="Enter title">
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- English Tab Content -->
                <div class="language-content" data-lang="en">
                    <div class="grid gap-4">
                        <div>
                            <label for="badge_en" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.badge') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="badge_en" name="badge_en"
                                value="{{ old('badge_en') }}" placeholder="Enter badge in English">
                            @error('badge_en')
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
                            <label for="badge_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.badge') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="badge_ar" name="badge_ar" required
                                value="{{ old('badge_ar') }}" placeholder="أدخل الاسم بالعربية">
                            @error('badge_ar')
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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            min="0">
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
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                <!-- Save Button -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.official-domains', 'model' => 'official_domain'])
            </div>
        </form>
    </div>
@endsection
