@extends('layouts.master')

@section('content')
    <section class="section portfolio text-center section-with-filter relative">
        <div class="title font-semibold">{{ __('main.projects_main_title') }} <span class="title-badge">{{ __('main.projects_main_badge') }}</span></div>
        <div class="description">{{ __('main.projects_main_description') }}</div>

        <div class="filter">
            <button class="btn-link main-color dark-hover font-semibold filter-btn active" data-filter="all">{{ __('main.all') }}</button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="web_design">{{ __('main.website_design') }}</button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="graphic_design">{{ __('main.graphic_design') }}</button>
        </div>

        <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if ($portfolio && count($portfolio) > 0)
                @foreach ($portfolio as $work)
                    @php
                        $slug = is_object($work) ? $work->slug : $work['slug'] ?? '';
                        $image = is_object($work) ? $work->image : $work['image'] ?? '';
                        $locale = app()->getLocale();
                        if (is_object($work)) {
                            $title = $work->translations[$locale]['name'] ?? $slug;
                            $tags = $work->tags ?? [];
                        } else {
                            $title = $work['translations'][$locale]['name'] ?? $slug;
                            $tags = $work['tags'] ?? [];
                        }
                        // Ensure tags is an array
                        if (is_string($tags)) {
                            $tags = json_decode($tags, true) ?? [];
                        }
                        // Convert tags to filter format (e.g., "Web Design" -> "web_design")
                        $filterTags = array_map(function ($tag) {
                            return strtolower(str_replace(' ', '_', $tag));
                        }, (array) $tags);
                        $tagsString = implode(',', $filterTags);
                    @endphp
                    <div class="project-item" data-tags="{{ $tagsString }}">
                        <a href="{{ route('portfolio.show', ['id' => $work->id ?? $work['id'], 'slug' => $slug]) }}">
                            <div class="project-image">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $slug }}" loading="lazy">
                            </div>
                            <div class="project-text">
                                <div class="project-title font-semibold">{{ $title }}</div>
                            </div>
                        </a>
                        <div class="project-action">
                            <button class="btn-link main-color font-semibold">
                                <a href="{{ route('portfolio.show', ['id' => $work->id ?? $work['id'], 'slug' => $slug]) }}">
                                    <i class="icon fa-solid fa-eye"></i>
                                </a>
                            </button>
                            <button class="btn-link main-color font-semibold">
                                <a href="#contact">
                                    <i class="icon fa-solid fa-search"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if (isDebugModeEnabled())
            <div class="debug-flag-badge">🚩 flag-portfolio</div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header.setAttribute('data-force-scrolled', 'true');
            header.classList.add('scrolled');
        });
    </script>
@endpush
