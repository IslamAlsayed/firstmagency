@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.dashboards_and_app')]))
@section('page-title', '🔧 ' . __('main.edit_type', ['type' => __('main.dashboards_and_app')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.dashboards-and-systems.update', $dashboardsAndSystem) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4">
                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- English Tab Content -->
                <div class="language-content" data-lang="en">
                    <div class="grid gap-4">
                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.title') }}
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_en" name="title_en"
                                value="{{ old('title_en', $dashboardsAndSystem->translations['en']['title'] ?? '') }}" placeholder="Enter title in English" required>
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
                                {{ __('main.title') }}
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_ar" name="title_ar"
                                value="{{ old('title_ar', $dashboardsAndSystem->translations['ar']['title'] ?? '') }}" placeholder="أدخل العنوان بالعربية" required>
                            @error('title_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Common Fields -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                    <input type="number" name="order" value="{{ old('order', $dashboardsAndSystem->order ?? 0) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" min="0">
                </div>

                <!-- Media & Other Fields -->
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.photo', ['column' => 'image', 'record' => $dashboardsAndSystem])
                </div>

                <!-- Update Button -->
                @include('dashboard.components.update-submit', [
                    'models' => 'dashboard.dashboards-and-systems',
                    'model' => 'dashboards_and_app',
                ])
            </div>
        </form>
    </div>
@endsection
