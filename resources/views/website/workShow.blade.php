@extends('layouts.master')

@section('content')
    <div class="work-sections">
        <section class="main-content">
            <div class="back">
                <a href="{{ route('portfolio') }}" class="btn-link cursor-pointer font-semibold">
                    {{ __('main.work_back') }}
                </a>
            </div>

            @if ($portfolio)
                <div class="banner">
                    @if ($portfolio instanceof \App\Models\Portfolio)
                        @if ($portfolio->image)
                            <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->translations['ar']['name'] ?? $portfolio->slug }}">
                        @else
                            <img src="{{ asset('assets/images/website/projects/' . $portfolio->id . '.png') }}" alt="">
                        @endif
                    @else
                        <img src="{{ asset('assets/images/website/projects/' . ($portfolio['id'] ?? 1) . '.png') }}" alt="">
                    @endif
                </div>

                <div class="info">
                    <div class="heading">
                        @if ($portfolio instanceof \App\Models\Portfolio)
                            {{ $portfolio->translations[app()->getLocale()]['name'] ?? $portfolio->slug }}
                        @else
                            {{ $portfolio['title'] ?? ($portfolio['name'] ?? '') }}
                        @endif
                    </div>

                    <div class="details flex item-center justify-between gap-4">
                        <div class="item">
                            <span>{{ __('main.work_title') }}</span>
                            <h5 class="font-semibold">
                                @if ($portfolio instanceof \App\Models\Portfolio)
                                    {{ $portfolio->translations[app()->getLocale()]['name'] ?? $portfolio->slug }}
                                @else
                                    {{ $portfolio['title'] ?? '' }}
                                @endif
                            </h5>
                        </div>

                        <div class="item">
                            <span>{{ __('main.work_year') }}</span>
                            <h5 class="font-semibold">
                                @if ($portfolio instanceof \App\Models\Portfolio)
                                    {{ optional($portfolio->published_at)->year ?? date('Y') }}
                                @else
                                    {{ $portfolio['year'] ?? date('Y') }}
                                @endif
                            </h5>
                        </div>

                        <div class="item">
                            <span>{{ __('main.work_category') }}</span>
                            <h5 class="font-semibold">
                                @if ($portfolio instanceof \App\Models\Portfolio)
                                    {{ $portfolio->slug ?? 'Project' }}
                                @else
                                    {{ $portfolio['slug'] ?? __('main.project') }}
                                @endif
                            </h5>
                        </div>

                        @if ($portfolio instanceof \App\Models\Portfolio)
                            @if ($portfolio->website)
                                <div class="item">
                                    <span>{{ __('main.work_location') }}</span>
                                    <h5 class="font-semibold">
                                        <a href="{{ $portfolio->website }}" target="_blank" class="text-primary hover:underline">
                                            {{ __('main.visit_website') }}
                                        </a>
                                    </h5>
                                </div>
                            @endif
                        @else
                            <div class="item">
                                <span>{{ __('main.work_location') }}</span>
                                <h5 class="font-semibold">{{ $portfolio['location'] ?? 'Egypt' }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        {{-- Similar Projects --}}
        @if ($similarProjects && count($similarProjects) > 0)
            <div class="section works-show-section work-section text-center">
                <h2 class="mb-8">{{ __('main.work_similar_projects') }}</h2>
                <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                    @foreach ($similarProjects as $project)
                        <div class="project-item">
                            <a href="{{ route('portfolio.show', [$project->id, $project->slug]) }}">
                                <div class="project-image">
                                    @if ($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->translations['ar']['name'] ?? $project->slug }}">
                                    @else
                                        <img src="{{ asset('assets/images/website/projects/' . $project->id . '.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="project-text">
                                    <div class="project-title font-semibold">
                                        {{ $project->translations[app()->getLocale()]['name'] ?? $project->slug }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif (config('projects_projects') && count(config('projects_projects')) > 0)
            <div class="section works-show-section work-section text-center">
                <h2 class="mb-8">{{ __('main.work_similar_projects') }}</h2>
                <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                    @foreach (config('projects_projects') as $key => $project)
                        @if ($key < 3)
                            <div class="project-item">
                                <a href="#">
                                    <div class="project-image">
                                        <img src="{{ asset('assets/images/website/projects/' . ($key + 1) . '.png') }}" alt="{{ $project['title'] }}">
                                    </div>
                                    <div class="project-text">
                                        <div class="project-title font-semibold">{{ $project['title'] }}</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-section mt-8 p-4 bg-gray-100 rounded">
            <h3 class="font-bold mb-4">🐛 Debug Info</h3>
            <details class="mb-4">
                <summary class="cursor-pointer font-semibold">Portfolio Data</summary>
                <pre class="mt-2 bg-white p-3 rounded overflow-auto text-xs">{{ json_encode($portfolio, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </details>
            <details>
                <summary class="cursor-pointer font-semibold">Similar Projects ({{ count($similarProjects ?? []) }})</summary>
                <pre class="mt-2 bg-white p-3 rounded overflow-auto text-xs">{{ json_encode($similarProjects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </details>
        </div>
    @endif
@endsection
