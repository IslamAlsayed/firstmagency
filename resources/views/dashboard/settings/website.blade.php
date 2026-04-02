@extends('dashboard.layout.master')

@section('title', __('main.settings'))
@section('page-title', '⚡ ' . __('main.settings'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
    <style>
        .toggle-icon {
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e5e7eb;
            border-radius: 9999px;
            transition: background-color 0.3s ease, transform 0.3s ease;

            &:hover {
                transform: translateY(-2px);
            }
        }
    </style>
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #06b6d4;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-globe"></i>
                        {{ __('main.settings') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.website_design') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.about_us') }} & {{ __('main.website_design') }}</p>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-chart-pie',
                    'items' => [
                        ['id' => 'stat-clients', 'value' => App\Models\Client::count(), 'label' => __('main.website_design_clients')],
                        ['id' => 'stat-projects', 'value' => App\Models\Project::count(), 'label' => __('main.website_design_projects')],
                        ['id' => 'stat-tickets', 'value' => App\Models\Ticket::count(), 'label' => __('main.website_design_support_ticket')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-laptop-code',
                'title' => __('main.website_design'),
                'description' => __('main.settings'),
            ])

            <div class="entity-content space-y-6">
                <div class="mt-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-info-circle text-amber-500"></i>
                            {{ __('main.about_us') }}
                        </div>

                        <div class="toggle-icon" toggle-button data-section="about-us-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <form action="{{ route('dashboard.settings.updateAboutUs') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="about-us-section">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="about-us-title" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }} (EN)</label>
                                <input type="text" id="about-us-title" name="about_us_title"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="{{ __('main.settings_about_us_title_placeholder') }}" value="{{ $settings->about_us_title ?? '' }}">
                            </div>
                            <div>
                                <label for="about-us-title-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.about_us_title') }} (AR)</label>
                                <input type="text" id="about-us-title-ar" name="about_us_title_ar"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                    placeholder="{{ __('main.settings_about_us_title_ar_placeholder') }}" value="{{ $settings->about_us_title_ar ?? '' }}">
                            </div>
                        </div>

                        <div class="col-span-full">
                            @include('dashboard.components.input-text-editor', [
                                'name' => 'about_us_description',
                                'value' => $settings->about_us_description,
                                'classes' => 'mb-4',
                            ])

                            @include('dashboard.components.input-text-editor', [
                                'name' => 'about_us_description_ar',
                                'value' => $settings->about_us_description_ar,
                            ])
                        </div>

                        @include('dashboard.components.photo', ['record' => $settings, 'column' => 'about_us_image'])
                        @include('dashboard.components.photo', ['record' => $settings, 'column' => 'about_us_image2'])

                        <button type="submit" class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            {{ __('main.settings_save_changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section class="entity-panel">
            <div class="entity-content space-y-6">
                {{-- <div class="bg-white radius-lg shadow-lg p-6"> --}}
                <div class="mt-4">
                    <h6 class="flex items-center justify-between gap-4 text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
                        <div>
                            <i class="fas fa-laptop-code text-blue-500"></i>
                            {{ __('main.website_design_title') }}
                        </div>

                        <div class="toggle-icon" toggle-button data-section="website-design-section">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                    </h6>

                    <form action="{{ route('dashboard.settings.updateWebsiteDesign') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="website-design-section">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4">
                            @include('dashboard.components.tabs-navigation')

                            <div class="language-content" data-lang="en">
                                <div class="grid gap-4">
                                    <div>
                                        <label for="website-design-title" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.title') }}</label>
                                        <input type="text" id="website-design-title" name="website_design_title"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="{{ __('main.settings_website_design_title_placeholder') }}" value="{{ $settings->website_design_title ?? '' }}">
                                    </div>

                                    <div>
                                        <label for="website-design-heading" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                        <input type="text" id="website-design-heading" name="website_design_heading"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="{{ __('main.settings_website_design_heading_placeholder') }}" value="{{ $settings->website_design_heading ?? '' }}">
                                    </div>

                                    @include('dashboard.components.input-text-editor', [
                                        'name' => 'website_design_description',
                                        'value' => $settings->website_design_description ?? '',
                                        'classes' => 'mb-4',
                                    ])
                                </div>
                            </div>

                            <div class="language-content hidden" data-lang="ar">
                                <div class="grid gap-4">
                                    <div>
                                        <label for="website-design-title-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.title') }}</label>
                                        <input type="text" id="website-design-title-ar" name="website_design_title_ar"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="{{ __('main.settings_website_design_title_ar_placeholder') }}" value="{{ $settings->website_design_title_ar ?? '' }}">
                                    </div>

                                    <div>
                                        <label for="website-design-heading-ar" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.heading') }}</label>
                                        <input type="text" id="website-design-heading-ar" name="website_design_heading_ar"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                            placeholder="{{ __('main.settings_website_design_heading_ar_placeholder') }}" value="{{ $settings->website_design_heading_ar ?? '' }}">
                                    </div>

                                    @include('dashboard.components.input-text-editor', [
                                        'name' => 'website_design_description_ar',
                                        'value' => $settings->website_design_description_ar ?? '',
                                        'classes' => 'mb-4',
                                    ])
                                </div>
                            </div>

                            @include('dashboard.components.photo', ['record' => $settings, 'column' => 'website_design_image'])

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="website-design-years" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.website_design_years_experience') }}</label>
                                    <input type="number" id="website-design-years" name="website_design_years_experience"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:border-transparent background text-gray-600 font-medium shadow-sm"
                                        placeholder="8" value="{{ $settings->website_design_years_experience ?? 8 }}" min="0">
                                </div>
                                <div class="text-sm text-blue-600 bg-blue-50 p-3 rounded-lg">
                                    <p><strong>{{ __('main.website_design_clients') }}:</strong> {{ App\Models\Client::count() }}</p>
                                    <p><strong>{{ __('main.website_design_projects') }}:</strong> {{ App\Models\Project::count() }}</p>
                                    <p><strong>{{ __('main.website_design_support_ticket') }}:</strong> {{ App\Models\Ticket::count() }}</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="flex items-center gap-2 px-4 py-2 cursor-pointer text-white bg-primary text-gray-600 font-semibold rounded-[9px] shadow-md">
                            <i class="fas fa-save"></i>
                            {{ __('main.settings_save_changes') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.drag-drop-images')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initCkEditors() {
                if (window.CKEDITOR) {
                    document.querySelectorAll('textarea.ckeditor').forEach(function(el) {
                        if (el.id && CKEDITOR.instances[el.id]) {
                            CKEDITOR.instances[el.id].destroy(true);
                        }
                        if (!el.classList.contains('ckeditor-initialized')) {
                            CKEDITOR.replace(el.id, {
                                height: 300
                            });
                            el.classList.add('ckeditor-initialized');
                        }
                    });
                } else {
                    setTimeout(initCkEditors, 300);
                }
            }
            initCkEditors();
        });
    </script>
@endpush
