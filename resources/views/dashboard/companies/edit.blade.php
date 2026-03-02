@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.company')]))
@section('page-title', '🏢 ' . __('main.edit_type', ['type' => __('main.company')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_type', ['type' => __('main.company')]) }}</h3>

            <a href="{{ route('dashboard.companies.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.companies')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.companies.update', $company->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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

                    <!-- Arabic Tab Content -->
                    <div class="language-content" data-lang="ar">
                        <div class="grid gap-4">
                            <div>
                                <label for="name_ar" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_ar"
                                    name="name_ar" required value="{{ old('name_ar', $company->translations['ar']['name'] ?? '') }}"
                                    placeholder="أدخل الاسم بالعربية">
                                @error('name_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="description_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                                <textarea
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description_ar') border-red-500 @enderror"
                                    id="description_ar" name="description_ar" rows="5" placeholder="أدخل الوصف بالعربية">{{ old('description_ar', $company->translations['ar']['description'] ?? '') }}</textarea>
                                @error('description_ar')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- English Tab Content -->
                    <div class="language-content hidden" data-lang="en">
                        <div class="grid gap-4">
                            <div>
                                <label for="name_en" class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ __('main.name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" id="name_en"
                                    name="name_en" required value="{{ old('name_en', $company->translations['en']['name'] ?? '') }}"
                                    placeholder="Enter name in English">
                                @error('name_en')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="description_en" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.description') }}</label>
                                <textarea
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description_en') border-red-500 @enderror"
                                    id="description_en" name="description_en" rows="5" placeholder="Enter description in English">{{ old('description_en', $company->translations['en']['description'] ?? '') }}</textarea>
                                @error('description_en')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.website') }}</label>
                            <input type="url" name="website" value="{{ old('website', $company->website) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('website') border-red-500 @enderror"
                                placeholder="https://example.com">
                            @error('website')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                            <input type="number" name="order" value="{{ old('order', $company->order) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" min="0">
                        </div>
                    </div>

                    <!-- Media & Other Fields -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['record' => $company, 'column' => 'image'])
                    </div>

                    <!-- Checkboxes -->
                    <div class="flex flex-wrap" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => old('is_active', $company->is_active),
                                'label' => __('main.active'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_featured" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_featured',
                                'id' => 'is_featured',
                                'value' => '1',
                                'checked' => old('is_featured', $company->is_featured),
                                'label' => __('main.featured'),
                            ])
                        </div>
                    </div>

                    <!-- Update Button -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.companies', 'model' => 'company'])
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.language-tab').forEach(button => {
            button.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');

                // Update tabs
                document.querySelectorAll('.language-tab').forEach(tab => {
                    tab.classList.remove('border-indigo-600', 'text-indigo-600', 'font-semibold');
                    tab.classList.add('border-transparent', 'text-gray-600');
                });
                this.classList.add('border-indigo-600', 'text-indigo-600', 'font-semibold');

                // Update content
                document.querySelectorAll('.language-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.querySelector(`.language-content[data-lang="${lang}"]`).classList.remove('hidden');
            });
        });
    </script>
@endpush
