<section class="section projects-section text-center section-with-filter relative">
    <div class="title font-semibold">{{ __('main.projects_main_title') }} <span class="title-badge">{{ __('main.projects_main_badge') }}</span></div>
    <div class="description">{{ __('main.projects_main_description') }}</div>

    <div class="filter">
        <button class="btn-link main-color dark-hover font-semibold filter-btn active" data-filter="all">{{ __('main.all') }}</button>
        <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="web_design">{{ __('main.website_design') }}</button>
        <button class="btn-link main-color dark-hover font-semibold filter-btn" data-filter="graphic_design">{{ __('main.graphic_design') }}</button>
    </div>

    <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @if (isset($projects) && count($projects) > 0)
            @foreach ($projects as $project)
                @php
                    $slug = is_object($project) ? $project->slug : $project['slug'] ?? '';
                    $image = is_object($project) ? $project->image : $project['image'] ?? '';
                    $locale = app()->getLocale();
                    if (is_object($project)) {
                        $title = $project->translations[$locale]['name'] ?? $slug;
                        $tags = $project->tags ?? [];
                    } else {
                        $title = $project['translations'][$locale]['name'] ?? $slug;
                        $tags = $project['tags'] ?? [];
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
                    <a href="{{ route('portfolio.show', ['id' => $project->id ?? $project['id'], 'slug' => $slug]) }}">
                        <div class="project-image">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $slug }}" loading="lazy">
                        </div>
                        <div class="project-text">
                            <div class="project-title font-semibold">{{ $title }}</div>
                        </div>
                    </a>
                    <div class="project-action">
                        <button class="btn-link main-color font-semibold">
                            <a href="{{ route('portfolio.show', ['id' => $project->id ?? $project['id'], 'slug' => $slug]) }}">
                                <i class="icon fa-solid fa-eye"></i>
                            </a>
                        </button>
                        <button class="btn-link main-color font-semibold">
                            <span class="clickable-img" data-src="{{ asset('assets/images/website/projects/' . $project['order'] . '.png') }}">
                                <i class="icon fa-solid fa-search"></i>
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            @if (count(config('projects_companies')) > 0)
                @foreach (config('projects_companies') as $id => $project)
                    @php
                        $tags = [];
                        // Ensure tags is an array
                        if (is_string($project['tags'])) {
                            $tags = json_decode($project['tags'], true) ?? [];
                        }
                        // Convert tags to filter format (e.g., "Web Design" -> "web_design")
                        $filterTags = array_map(function ($tag) {
                            return strtolower(str_replace(' ', '_', $tag));
                        }, (array) $tags);
                        $tagsString = implode(',', $filterTags);
                    @endphp
                    <div class="project-item" data-tags="{{ $tagsString }}">
                        <a href="{{ route('portfolio.show', ['id' => $id, 'slug' => str_replace(' ', '-', strtolower($project['title']))]) }}">
                            <div class="project-image">
                                <img src="{{ asset('assets/images/website/projects/' . $project['order'] . '.png') }}" alt="{{ $project['title'] }}" loading="lazy">
                            </div>
                            <div class="project-text">
                                <div class="project-title font-semibold">{{ $project['title'] }}</div>
                            </div>
                        </a>
                        <div class="project-action">
                            <button class="btn-link main-color font-semibold">
                                <a href="{{ route('portfolio.show', ['id' => $id, 'slug' => str_replace(' ', '-', strtolower($project['title']))]) }}">
                                    <i class="icon fa-solid fa-eye"></i>
                                </a>
                            </button>
                            <button class="btn-link main-color font-semibold">
                                <span class="clickable-img" data-src="{{ asset('assets/images/website/projects/' . $project['order'] . '.png') }}">
                                    <i class="icon fa-solid fa-search"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 col-span-full">
                    <p class="text-gray-500">{{ __('main.no_projects_found') }}</p>
                </div>
            @endif
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-projects</div>
    @endif
</section>
