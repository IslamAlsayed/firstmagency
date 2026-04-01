@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.hosting_package')]))
@section('page-title', '📦 ' . __('main.create_type', ['type' => __('main.hosting_package')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.hosting-packages.store') ?? '#' }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- English Tab Content -->
                <div class="language-content" data-lang="en">
                    <div class="grid gap-4">
                        <div>
                            <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title_en') }}</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_en" name="title_en"
                                value="{{ old('title_en') }}" placeholder="Enter title in English">
                            @error('title_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="description_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description_en') }}</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="description_en" name="description_en" rows="3"
                                placeholder="Enter description in English">{{ old('description_en') }}</textarea>
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
                                {{ __('main.title_ar') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_ar" name="title_ar" required
                                value="{{ old('title_ar') }}" placeholder="أدخل العنوان بالعربية">
                            @error('title_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="description_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description_ar') }}</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="description_ar" name="description_ar" rows="3"
                                placeholder="أدخل الوصف بالعربية">{{ old('description_ar') }}</textarea>
                            @error('description_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="monthly_price" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.monthly_price') }} <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="monthly_price" name="monthly_price"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('monthly_price') }}" required
                            placeholder="0.00">
                        @error('monthly_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="yearly_price" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.yearly_price') }} <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="yearly_price" name="yearly_price"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('yearly_price') }}" required placeholder="0.00">
                        @error('yearly_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Category & Status (Common) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-600 mb-1">
                            {{ __('main.category') }} <span class="text-red-500">*</span>
                        </label>
                        <select class="kt-select basic-single" id="category" name="category" required>
                            <option value="" selected disabled>--</option>
                            <option value="hosting" {{ old('category') == 'hosting' ? 'selected' : '' }}>{{ __('main.hosting_packages_shared') }}</option>
                            <option value="reseller" {{ old('category') == 'reseller' ? 'selected' : '' }}>{{ __('main.hosting_packages_reseller') }}</option>
                            <option value="vps" {{ old('category') == 'vps' ? 'selected' : '' }}>{{ __('main.hosting_packages_vps') }}</option>
                            <option value="servers" {{ old('category') == 'servers' ? 'selected' : '' }}>{{ __('main.hosting_packages_dedicated') }}</option>
                        </select>
                        @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                        <input type="number" id="order" name="order" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            value="{{ old('order', 0) }}" placeholder="0">
                        @error('order')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Photo Upload -->
                @include('dashboard.components.photo', ['column' => 'image'])

                <!-- Features -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h6 class="block text-sm font-medium text-gray-600">{{ __('main.features') }}</h6>
                        <button type="button" id="addFeatureBtn" class="kt-btn kt-btn-sm kt-btn-outline-primary">
                            <i class="fas fa-plus mr-2"></i> {{ __('main.add_feature') }}
                        </button>
                    </div>

                    <div id="featuresContainer" class="space-y-4">
                        <!-- Features will be added here -->
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
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_popular" value="0">
                        @include('dashboard.components.checkbox-button', [
                            'name' => 'is_popular',
                            'id' => 'is_popular',
                            'value' => '1',
                            'checked' => old('is_popular', 0),
                            'label' => __('main.popular'),
                        ])
                    </div>
                </div>

                <!-- Save Submit -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.hosting-packages', 'model' => 'hosting_package'])
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addFeatureBtn = document.getElementById('addFeatureBtn');
            const featuresContainer = document.getElementById('featuresContainer');

            addFeatureBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const index = featuresContainer.children.length;
                const featureHTML = `
                    <div class="feature-row border border-gray-200 rounded-lg p-4 bg-gray-50" data-index="${index}">
                        <div class="flex justify-end mb-2">
                            <button type="button" class="remove-feature-btn kt-btn bg-danger text-sm">
                                <i class="fas fa-trash mr-1"></i> {{ __('main.remove') }}
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title') }} EN</label>
                                <input type="text" name="feature_title_en[${index}]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title') }} AR</label>
                                <input type="text" name="feature_title_ar[${index}]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.label') }} EN</label>
                                <input type="text" name="feature_label_en[${index}]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.label') }} AR</label>
                                <input type="text" name="feature_label_ar[${index}]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                `;
                featuresContainer.insertAdjacentHTML('beforeend', featureHTML);
            });

            // Remove feature button listener
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-feature-btn')) {
                    e.preventDefault();
                    e.target.closest('.feature-row').remove();
                }
            });
        });
    </script>
@endpush
