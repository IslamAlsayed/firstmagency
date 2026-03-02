@extends('dashboard.layout.master')

@section('title', __('main.create_article'))
@section('page-title', '📝 ' . __('main.create_article'))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.create_article') }}</h3>

            <a href="{{ route('dashboard.articles.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.articles')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.articles.store') ?? '#' }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 lg:gap-6">
                    <!-- Tabs Navigation -->
                    <div class="flex border-b border-gray-300">
                        <button type="button" data-lang="ar"
                            class="language-tab cursor-pointer px-4 py-2 border-b-2 border-indigo-600 text-indigo-600 font-semibold">
                            EG {{ __('main.arabic') }}
                        </button>
                        <button type="button" data-lang="en"
                            class="language-tab cursor-pointer px-4 py-2 border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                            🇺🇸 {{ __('main.english') }}
                        </button>
                    </div>
                    <!-- Category (Common) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.category') }}</label>
                            <select class="kt-select basic-single" id="category_id" name="category_id">
                                <option value="">--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.status') }} <span class="text-red-500">*</span>
                            </label>
                            <select class="kt-select basic-single" id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('main.draft') }}</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('main.published') }}</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>{{ __('main.archived') }}</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Arabic Tab Content -->
                    <div class="language-content" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.title_ar') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_ar"
                                    name="title_ar" required value="{{ old('title_ar') }}" placeholder="أدخل العنوان بالعربية">
                                @error('title_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- الوصف --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'description_ar',
                                    'value' => old('description_ar'),
                                    'placeholder' => 'أدخل الوصف بالعربية',
                                ])

                                {{-- المحتوى --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'content_ar',
                                    'value' => old('content_ar'),
                                    'placeholder' => 'أدخل المحتوى بالعربية',
                                ])
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="keywords_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.keywords_ar') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="keywords_ar" name="keywords_ar" value="{{ old('keywords_ar') }}" placeholder="كلمة1، كلمة2، كلمة3">
                                    @error('keywords_ar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meta_description_ar"
                                        class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.meta_description_ar') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="meta_description_ar" name="meta_description_ar" value="{{ old('meta_description_ar') }}" maxlength="300"
                                        placeholder="وصف الميتا بالعربية">
                                    @error('meta_description_ar')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- English Tab Content -->
                    <div class="language-content hidden" data-lang="en">
                        <div class="grid gap-4">
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.title_en') }}</label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="title_en"
                                    name="title_en" value="{{ old('title_en') }}" placeholder="Enter title in English">
                                @error('title_en')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- Description --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'description_en',
                                    'value' => old('description_en'),
                                    'placeholder' => 'Enter description in English',
                                ])

                                {{-- Content --}}
                                @include('dashboard.components.input-text-editor', [
                                    'name' => 'content_en',
                                    'value' => old('content_en'),
                                    'placeholder' => 'Enter content in English',
                                ])
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="keywords_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.keywords_en') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="keywords_en" name="keywords_en" value="{{ old('keywords_en') }}" placeholder="keyword1, keyword2, keyword3">
                                    @error('keywords_en')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meta_description_en"
                                        class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.meta_description_en') }}</label>
                                    <input type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                        id="meta_description_en" name="meta_description_en" value="{{ old('meta_description_en') }}" maxlength="300"
                                        placeholder="Meta description in English">
                                    @error('meta_description_en')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media & Other Fields -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['column' => 'photo'])
                        @include('dashboard.components.photo', ['column' => 'thumbnail'])
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
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="featured" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'featured',
                                'id' => 'featured',
                                'value' => '1',
                                'checked' => 0,
                                'label' => __('main.featured'),
                            ])
                        </div>
                    </div>

                    <!-- Submit Button -->
                    @include('dashboard.components.save-submit', ['models' => 'dashboard.articles', 'model' => 'article'])
                </div>
            </form>
        </div>
    </div>

    <script>
        // Language tab switching
        document.querySelectorAll('.language-tab').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.dataset.lang;

                // Update tab active state
                document.querySelectorAll('.language-tab').forEach(btn => {
                    btn.classList.remove('border-indigo-600', 'text-indigo-600');
                    btn.classList.add('border-transparent', 'text-gray-600');
                });
                this.classList.add('border-indigo-600', 'text-indigo-600');
                this.classList.remove('border-transparent', 'text-gray-600');

                // Update content visibility
                document.querySelectorAll('.language-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.querySelector(`[data-lang="${lang}"].language-content`).classList.remove('hidden');
            });
        });
    </script>
@endsection
