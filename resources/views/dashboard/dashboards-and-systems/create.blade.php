@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.dashboards_and_app')]))
@section('page-title', '🔧 ' . __('main.create_type', ['type' => __('main.dashboards_and_app')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_type', ['type' => __('main.dashboards_and_app')]) }}</h3>

            <a href="{{ route('dashboard.dashboards-and-systems.index') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                {{ __('main.back_to_types', ['types' => __('main.dashboards_and_apps')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.dashboards-and-systems.store') }}" enctype="multipart/form-data">
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
                                    value="{{ old('title_en') }}" placeholder="Enter title in English" required>
                                @error('title_en')
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
                                    required value="{{ old('title_ar') }}" placeholder="أدخل العنوان بالعربية" required>
                                @error('title_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            min="0">
                    </div>

                    <!-- Media & Other Fields -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['column' => 'image'])
                    </div>

                    <!-- Save Button -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.dashboards-and-systems', 'model' => 'dashboards_and_app'])
                </div>
            </form>
        </div>
    </div>
@endsection
