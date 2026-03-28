@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.project_step')]))
@section('page-title', '✏️ ' . __('main.edit_type', ['type' => __('main.project_step')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.project-steps.update', $projectStep->id) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-6">
                <!-- Tabs Navigation -->
                @include('dashboard.components.tabs-navigation')

                <!-- English Tab Content -->
                <div class="language-content" data-lang="en">
                    <div class="grid gap-6">
                        <!-- Title English -->
                        <div>
                            <label for="title_en" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.title') }}
                            </label>
                            <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $projectStep->translations['en']['title'] ?? '') }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('title_en') border-red-500 @enderror"
                                placeholder="Enter title in English">
                            @error('title_en')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content English -->
                        <div>
                            <label for="content_en" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.content') }}
                            </label>
                            <textarea id="content_en" name="content_en" rows="5"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('content_en') border-red-500 @enderror" placeholder="Enter content in English">{{ old('content_en', $projectStep->translations['en']['content'] ?? '') }}</textarea>
                            @error('content_en')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Arabic Tab Content -->
                <div class="language-content hidden" data-lang="ar">
                    <div class="grid gap-6">
                        <!-- Title Arabic -->
                        <div>
                            <label for="title_ar" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.title') }}
                            </label>
                            <input type="text" id="title_ar" name="title_ar" value="{{ old('title_ar', $projectStep->translations['ar']['title'] ?? '') }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('title_ar') border-red-500 @enderror"
                                placeholder="أدخل العنوان بالعربية">
                            @error('title_ar')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content Arabic -->
                        <div>
                            <label for="content_ar" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.content') }}
                            </label>
                            <textarea id="content_ar" name="content_ar" rows="5"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('content_ar') border-red-500 @enderror" placeholder="أدخل المحتوى بالعربية">{{ old('content_ar', $projectStep->translations['ar']['content'] ?? '') }}</textarea>
                            @error('content_ar')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Icon (Common Field) -->
                <div class="grid grid-cols-2 items-center gap-4">
                    <div>
                        <label for="icon" class="flex gap-6 text-sm font-semibold text-gray-700">
                            <div>
                                {{ __('main.icon') }}
                            </div>

                            <div id="iconPreview" class="text-2xl text-gray-600">
                                <i class="{{ old('icon', $projectStep->icon ?? 'fas fa-folder') }}"></i>
                            </div>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $projectStep->icon ?? '') }}"
                                class="flex-1 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('icon') border-red-500 @enderror" placeholder="fas fa-chart-pie">
                        </div>
                        @error('icon')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="mb-2 block text-sm font-semibold text-gray-700">
                            {{ __('main.order') }}
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $projectStep->order) }}" min="0"
                            class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
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
@endsection

@push('scripts')
    <script>
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');

        if (iconInput) {
            iconInput.addEventListener('input', function() {
                iconPreview.innerHTML = `<i class="${this.value}"></i>`;
            });
        }
    </script>
@endpush
