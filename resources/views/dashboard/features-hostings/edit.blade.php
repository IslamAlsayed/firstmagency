@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.features_hosting')]))
@section('page-title', '✏️ ' . __('main.edit_type', ['type' => __('main.features_hosting')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_type', ['type' => __('main.features_hosting')]) }}</h3>

            <a href="{{ route('dashboard.features-hostings.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.features_hostings')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.features-hostings.update', $featuresHosting->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-6">
                    <!-- Tabs Navigation -->
                    @include('dashboard.components.tabs-navigation')

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.image') }}
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="file" id="image" name="image" accept="image/*"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/40 @error('image') border-red-500 @enderror">
                            <div id="imagePreview" class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if ($featuresHosting->image)
                                    <img src="{{ asset('storage/' . $featuresHosting->image) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                @endif
                            </div>
                        </div>
                        @error('image')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.order') }}
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $featuresHosting->order) }}" min="0"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                    </div>

                    <!-- Arabic Tab Content -->
                    <div class="language-content" data-lang="ar">
                        <div class="grid gap-6">
                            <!-- Title Arabic -->
                            <div>
                                <label for="title_ar" class="mb-2 block text-sm font-semibold text-gray-700">
                                    {{ __('main.title') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar', $featuresHosting->translations['ar']['title'] ?? '') }}"
                                    class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('title_ar') border-red-500 @enderror"
                                    placeholder="أدخل العنوان بالعربية">
                                @error('title_ar')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Arabic -->
                            <div>
                                <label for="description_ar" class="mb-2 block text-sm font-semibold text-gray-700">
                                    {{ __('main.description') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description_ar" name="description_ar" rows="5"
                                    class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('description_ar') border-red-500 @enderror"
                                    placeholder="أدخل الوصف بالعربية">{{ old('description_ar', $featuresHosting->translations['ar']['description'] ?? '') }}</textarea>
                                @error('description_ar')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- English Tab Content -->
                    <div class="language-content hidden" data-lang="en">
                        <div class="grid gap-6">
                            <!-- Title English -->
                            <div>
                                <label for="title_en" class="mb-2 block text-sm font-semibold text-gray-700">
                                    {{ __('main.title') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $featuresHosting->translations['en']['title'] ?? '') }}"
                                    class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('title_en') border-red-500 @enderror"
                                    placeholder="Enter title in English">
                                @error('title_en')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description English -->
                            <div>
                                <label for="description_en" class="mb-2 block text-sm font-semibold text-gray-700">
                                    {{ __('main.description') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description_en" name="description_en" rows="5"
                                    class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('description_en') border-red-500 @enderror"
                                    placeholder="Enter description in English">{{ old('description_en', $featuresHosting->translations['en']['description'] ?? '') }}</textarea>
                                @error('description_en')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Update Button -->
                    <div class="flex gap-2 pt-4">
                        <button type="submit" class="kt-btn kt-btn-primary">
                            <i class="fas fa-save mr-2"></i>{{ __('main.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            imagePreview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        </script>
    @endpush
@endsection
