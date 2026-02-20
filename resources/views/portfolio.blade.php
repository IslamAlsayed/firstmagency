@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color);
            box-shadow: 0 0px 15px -2px rgba(0, 0, 0, 0.1);
            background-image: url('../images/header-bg.png');
            background-position: center center;
            background-size: contain;
            background-repeat: repeat;
        }
    </style>
@endpush

@section('content')
    <div class="section projects-section portfolio text-center">
        <div class="title font-semibold">{{ __('main.projects_main_title') }} <span class="title-badge">{{ __('main.projects_main_badge') }}</span></div>
        <div class="description">{{ __('main.projects_main_description') }}</div>

        <div class="filter">
            <button class="btn-link main-color dark-hover font-semibold filter-btn active" data-filter="all">{{ __('main.all') }}</button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="website_design">{{ __('main.website_design') }}</button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="graphic_design">{{ __('main.graphic_design') }}</button>
        </div>

        <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach (config('portfolio') as $key => $work)
                <div class="project-item" data-tags="{{ isset($work['tags']) && is_array($work['tags']) ? implode(',', $work['tags']) : '' }}">
                    <a href="#">
                        <div class="project-image">
                            <img src="{{ asset('assets/images/portfolio/' . ($key + 1) . '.jpg') }}" alt="{{ $work['title'] }}">
                        </div>
                        <div class="project-text">
                            <div class="project-title font-semibold">{{ isset($work['title']) && $work['title'] ? $work['title'] : '' }}</div>
                            @if (isset($work['description']) && $work['description'])
                                <div class="project-description font-semibold">{{ $work['description'] }}</div>
                            @endif
                        </div>
                    </a>
                    <div class="project-action">
                        <button class="btn-link main-color dark-hover font-semibold">
                            <a href="{{ route('works.show') }}">
                                <i class="icon fa-solid fa-eye"></i>
                            </a>
                        </button>
                        <button class="btn-link main-color dark-hover font-semibold">
                            <a href="#contact">
                                <i class="icon fa-solid fa-search"></i>
                            </a>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
