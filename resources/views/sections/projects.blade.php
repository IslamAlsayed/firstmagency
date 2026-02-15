<div class="container section projects-section text-center">
    <div class="title font-semibold">{{ __('main.projects_main_title') }} <span class="title-badge">{{ __('main.projects_main_badge') }}</span></div>
    <div class="description">{{ __('main.projects_main_description') }}</div>

    @php
        $companies = __('main.projects_companies');
    @endphp

    <div class="our-projects-wrapper grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($companies as $key => $company)
            <div class="project-item">
                <a href="#">
                    <div class="project-image">
                        <img src="{{ asset('assets/images/projects/' . ($key + 1) . '.png') }}" alt="{{ $company }}">
                    </div>
                    <div class="project-text">
                        <div class="project-title font-semibold">{{ $company }}</div>
                    </div>
                </a>
                <div class="project-action">
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#go">
                            <i class="icon fa-solid fa-square-arrow-up-right"></i>
                        </a>
                    </button>
                    <button class="btn-link main-color dark-hover font-semibold">
                        <a href="#views">
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
