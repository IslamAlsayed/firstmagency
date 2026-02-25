@extends('layouts.master')

@section('content')
    <div class="work-sections">
        <section class="main-content">
            <div class="back">
                <a href="/" class="btn-link cursor-pointer font-semibold">
                    {{ __('main.work_back') }}
                </a>
            </div>
            <div class="banner">
                <img src="{{ asset('assets/images/projects/1.png') }}" alt="">
            </div>

            <div class="info">
                <div class="heading">{{ __('main.work_heading') }}</div>
                <div class="details flex item-center justify-between gap-4">
                    <div class="item">
                        <span>{{ __('main.work_title') }}</span>
                        <h5 class="font-semibold">{{ __('main.work_heading') }}</h5>
                    </div>
                    <div class="item">
                        <span>{{ __('main.work_year') }}</span>
                        <h5 class="font-semibold">2025</h5>
                    </div>
                    <div class="item">
                        <span>{{ __('main.work_category') }}</span>
                        <h5 class="font-semibold">{{ __('main.work_category_title') }}</h5>
                    </div>
                    <div class="item">
                        <span>{{ __('main.work_location') }}</span>
                        <h5 class="font-semibold">{{ __('main.work_location_title') }}</h5>
                    </div>
                </div>
            </div>
        </section>

        <div class="section works-show-section work-section text-center">
            <h2 class="mb-8">{{ __('main.work_similar_projects') }}</h2>
            <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                @if (config('projects_companies') && count(config('projects_companies')) > 0)
                    @foreach (config('projects_companies') as $key => $company)
                        @if ($key < 3)
                            <div class="project-item"
                                data-tags="{{ isset($company['tags']) && is_array($company['tags']) ? implode(',', $company['tags']) : '' }}">
                                <a href="#">
                                    <div class="project-image">
                                        <img src="{{ asset('assets/images/projects/' . ($key + 1) . '.png') }}" alt="{{ $company['title'] }}">
                                    </div>
                                    <div class="project-text">
                                        <div class="project-title font-semibold">{{ $company['title'] }}</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
