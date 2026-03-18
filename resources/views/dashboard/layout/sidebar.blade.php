<aside id="sidebar" class="sidebar fixed top-0 left-0 bg-gray-900 text-white shadow-lg flex flex-col" data-sortable-group="sidebar-menu">
    <div class="layout"></div>
    <div class="sidebar-logo flex items-center justify-between">
        <h4>
            <a href="{{ route('dashboard.index') }}">
                🎛️
                <span>{{ __('main.brand_name') }}</span>
            </a>
        </h4>
        <!-- Close button for small screens -->
        <button id="closeSidebar" class="p-2 rounded-lg hover:bg-slate-700">
            <i class="fas fa-xmark text-xl text-red-600"></i>
        </button>
    </div>

    <ul id="sidebarMenu" class="nav-menu sortable-menu" data-group="sidebar-items">
        <!-- System Management -->
        @if (auth()->user()->can('users-read') || auth()->user()->can('users-create') || auth()->user()->can('departments-read') || auth()->user()->can('departments-create'))
            <li class="relative group submenu-item" data-item-id="system-management" title="{{ __('main.system') }}">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.users.*', 'dashboard.departments.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">⚙️</span>
                        <span class="span-text">{{ limitedText(__('main.system'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.users.*', 'dashboard.departments.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('users-read') || auth()->user()->can('users-create'))
                        <li class="relative" data-sub-id="users" title="{{ __('main.user') }}">
                            <a href="{{ route('dashboard.users.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="text-sm">{{ __('main.user') }}</span>
                            </a>
                        </li>
                    @endif

                    <!-- Departments -->
                    @if (auth()->user()->can('departments-read') || auth()->user()->can('departments-create'))
                        <li class="relative" data-sub-id="departments" title="{{ __('main.department') }}">
                            <a href="{{ route('dashboard.departments.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.departments.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="text-sm">{{ __('main.department') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Roles & Permissions -->
        @if (auth()->user()->can('roles-read') || auth()->user()->can('roles-create') || auth()->user()->can('permissions-read') || auth()->user()->can('permissions-create'))
            <li class="relative group submenu-item" data-item-id="roles-permissions">
                <button type="button" data-toggle="submenu" title="{{ __('main.permissions') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🔐</span>
                        <span class="span-text">{{ limitedText(__('main.permissions'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.roles.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('roles-read') || auth()->user()->can('roles-create'))
                        <li class="relative" data-sub-id="roles" title="{{ __('main.role') }}">
                            <a href="{{ route('dashboard.roles.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🔐</span>
                                <span class="text-sm">{{ __('main.role') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('permissions-read') || auth()->user()->can('permissions-create'))
                        <li class="relative" data-sub-id="permissions" title="{{ __('main.permission') }}">
                            <a href="{{ route('dashboard.permissions.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🔐</span>
                                <span class="text-sm">{{ __('main.permission') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Tickets -->
        @if (auth()->user()->can('tickets-read') || auth()->user()->can('tickets-create'))
            <li class="relative group submenu-item" data-item-id="tickets" title="{{ __('main.tickets') }}">
                <button type="button" data-toggle="submenu" title="{{ __('main.tickets') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.tickets.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🎫</span>
                        <span class="span-text">{{ limitedText(__('main.tickets'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.tickets.*') ? 'show' : '' }}">
                    <li class="relative" data-sub-id="tickets" title="{{ __('main.tickets') }}">
                        <a href="{{ route('dashboard.tickets.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.tickets.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <span class="main-icon">🎫</span>
                            <span class="text-sm">{{ __('main.tickets') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Content Management -->
        @if (auth()->user()->can('articles-read') || auth()->user()->can('articles-create'))
            <li class="relative group submenu-item" data-item-id="content-management" title="{{ __('main.content_management') }}">
                <button type="button" data-toggle="submenu" title="{{ __('main.content_management') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.articles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📝</span>
                        <span class="span-text">{{ limitedText(__('main.content_management'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.articles.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('articles-read') || auth()->user()->can('articles-create'))
                        <li class="relative" data-sub-id="articles" title="{{ __('main.article') }}">
                            <a href="{{ route('dashboard.articles.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.articles.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📝</span>
                                <span class="text-sm">{{ __('main.article') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Clients & Partners -->
        @if (auth()->user()->can('clients-read') || auth()->user()->can('clients-create') || auth()->user()->can('partners-read') || auth()->user()->can('partners-create'))
            <li class="relative group submenu-item" data-item-id="clients-partners">
                <button type="button" data-toggle="submenu" title="{{ __('main.entities_and_partners') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.clients.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">👥</span>
                        <span class="span-text">{{ limitedText(__('main.entities_and_partners'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.clients.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('clients-read') || auth()->user()->can('clients-create'))
                        <li class="relative" data-sub-id="clients" title="{{ __('main.clients') }}">
                            <a href="{{ route('dashboard.clients.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.clients.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">👥</span>
                                <span class="text-sm">{{ __('main.clients') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('partners-read') || auth()->user()->can('partners-create'))
                        <li class="relative" data-sub-id="partners" title="{{ __('main.partners') }}">
                            <a href="{{ route('dashboard.partners.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.partners.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🤝</span>
                                <span class="text-sm">{{ __('main.partners') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Services & Projects -->
        @if (auth()->user()->can('services-read') || auth()->user()->can('services-create') || auth()->user()->can('projects-read') || auth()->user()->can('projects-create'))
            <li class="relative group submenu-item" data-item-id="services-projects">
                <button type="button" data-toggle="submenu" title="{{ __('main.services_and_projects') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.services.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">💼</span>
                        <span class="span-text">{{ limitedText(__('main.services_and_projects'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.services.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('services-read') || auth()->user()->can('services-create'))
                        <li class="relative" data-sub-id="services" title="{{ __('main.service') }}">
                            <a href="{{ route('dashboard.services.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.services.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📝</span>
                                <span class="text-sm">{{ __('main.service') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('projects-read') || auth()->user()->can('projects-create'))
                        <li class="relative" data-sub-id="projects" title="{{ __('main.projects') }}">
                            <a href="{{ route('dashboard.projects.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.projects.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🏢</span>
                                <span class="text-sm">{{ __('main.projects') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Programming & Development -->
        @if (auth()->user()->can('programming-systems-read') ||
                auth()->user()->can('programming-systems-create') ||
                auth()->user()->can('programming-categories-read') ||
                auth()->user()->can('programming-categories-create'))
            <li class="relative group submenu-item" data-item-id="programming-development">
                <button type="button" data-toggle="submenu" title="{{ __('main.programmings') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.programming-systems.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">💻</span>
                        <span class="span-text">{{ limitedText(__('main.programmings'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.programming-systems.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('programming-systems-read') || auth()->user()->can('programming-systems-create'))
                        <li class="relative" data-sub-id="programming-systems" title="{{ __('main.programming-systems') }}">
                            <a href="{{ route('dashboard.programming-systems.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.programming-systems.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">💻</span>
                                <span class="text-sm">{{ __('main.programming-systems') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('programming-categories-read') || auth()->user()->can('programming-categories-create'))
                        <li class="relative" data-sub-id="programming-categories" title="{{ __('main.programming-categories') }}">
                            <a href="{{ route('dashboard.programming-categories.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.programming-categories.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🎫</span>
                                <span class="text-sm">{{ __('main.programming-categories') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- FAQs & Reviews -->
        @if (auth()->user()->can('faqs-read') || auth()->user()->can('faqs-create') || auth()->user()->can('reviews-read') || auth()->user()->can('reviews-create'))
            <li class="relative group submenu-item" data-item-id="faqs-reviews">
                <button type="button" data-toggle="submenu" title="{{ __('main.faqs_and_reviews') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.faqs.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">❓</span>
                        <span class="span-text">{{ limitedText(__('main.faqs_and_reviews'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.faqs.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('faqs-read') || auth()->user()->can('faqs-create'))
                        <li class="relative" data-sub-id="faqs" title="{{ __('main.faqs') }}">
                            <a href="{{ route('dashboard.faqs.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.faqs.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">❓</span>
                                <span class="text-sm">{{ __('main.faqs') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('reviews-read') || auth()->user()->can('reviews-create'))
                        <li class="relative" data-sub-id="reviews" title="{{ __('main.reviews') }}">
                            <a href="{{ route('dashboard.reviews.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.reviews.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">⭐</span>
                                <span class="text-sm">{{ __('main.reviews') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Hosting Packages -->
        @if (auth()->user()->can('hosting-packages-read') ||
                auth()->user()->can('hosting-packages-create') ||
                auth()->user()->can('marketing-packages-read') ||
                auth()->user()->can('marketing-packages-create'))
            <li class="relative group submenu-item" data-item-id="packages-domains">
                <button type="button" data-toggle="submenu" title="{{ __('main.packages_and_domains') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.hosting-packages.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📦</span>
                        <span class="span-text">{{ limitedText(__('main.packages_and_domains'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.hosting-packages.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('hosting-packages-read') || auth()->user()->can('hosting-packages-create'))
                        <li class="relative" data-sub-id="hosting-packages" title="{{ __('main.hosting_packages') }}">
                            <a href="{{ route('dashboard.hosting-packages.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.hosting-packages.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📦</span>
                                <span class="text-sm">{{ __('main.hosting_packages') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('marketing-packages-read') || auth()->user()->can('marketing-packages-create'))
                        <li class="relative" data-sub-id="marketing-packages" title="{{ __('main.marketing_package') }}">
                            <a href="{{ route('dashboard.marketing-packages.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.marketing-packages.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📦</span>
                                <span class="text-sm">{{ __('main.marketing_package') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('pest-domains-read') || auth()->user()->can('pest-domains-create'))
                        <li class="relative" data-sub-id="pest-domains" title="{{ __('main.pest_domains') }}">
                            <a href="{{ route('dashboard.pest-domains.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pest-domains.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🌐</span>
                                <span class="text-sm">{{ __('main.pest_domains') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('official-domains-read') || auth()->user()->can('official-domains-create'))
                        <li class="relative" data-sub-id="official-domains" title="{{ __('main.official_domains') }}">
                            <a href="{{ route('dashboard.official-domains.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.official-domains.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🌐</span>
                                <span class="text-sm">{{ __('main.official_domains') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Projects & Steps -->
        @if (auth()->user()->can('projects-read') || auth()->user()->can('projects-create') || auth()->user()->can('steps-read') || auth()->user()->can('steps-create'))
            <li class="relative group submenu-item" data-item-id="projects-steps">
                <button type="button" data-toggle="submenu" title="{{ __('main.projects_and_steps') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.project-steps.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📋</span>
                        <span class="span-text">{{ limitedText(__('main.projects_and_steps'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.project-steps.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('line-works-read') || auth()->user()->can('line-works-create'))
                        <li class="relative" data-sub-id="line-works" title="{{ __('main.line_works') }}">
                            <a href="{{ route('dashboard.line-works.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.line-works.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">⚙️</span>
                                <span class="text-sm">{{ __('main.line_works') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('project-steps-read') || auth()->user()->can('project-steps-create'))
                        <li class="relative" data-sub-id="project-steps" title="{{ __('main.project_steps') }}">
                            <a href="{{ route('dashboard.project-steps.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.project-steps.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📋</span>
                                <span class="text-sm">{{ __('main.project_steps') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('work-us-step-read') || auth()->user()->can('work-us-step-create'))
                        <li class="relative" data-sub-id="work-us-step" title="{{ __('main.work_us_step') }}">
                            <a href="{{ route('dashboard.work-us-step.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.work-us-step.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">👔</span>
                                <span class="text-sm">{{ __('main.work_us_step') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('why-us-read') || auth()->user()->can('why-us-create'))
                        <li class="relative" data-sub-id="why-us" title="{{ __('main.why_us') }}">
                            <a href="{{ route('dashboard.why-us.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.why-us.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🌟</span>
                                <span class="text-sm">{{ __('main.why_us') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <!-- Features Hosting -->
        @if (auth()->user()->can('hosting-features-read') ||
                auth()->user()->can('hosting-features-create') ||
                auth()->user()->can('dashboards-and-systems-read') ||
                auth()->user()->can('dashboards-and-systems-create'))
            <li class="relative group submenu-item" data-item-id="hosting-features">
                <button type="button" data-toggle="submenu" title="{{ __('main.features_and_system') }}"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.hosting-features.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🎁</span>
                        <span class="span-text">{{ limitedText(__('main.features_and_system'), 20) }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.hosting-features.*') ? 'show' : '' }}">
                    @if (auth()->user()->can('hosting-features-read') || auth()->user()->can('hosting-features-create'))
                        <li class="relative" data-sub-id="hosting-features" title="{{ __('main.features_hostings') }}">
                            <a href="{{ route('dashboard.hosting-features.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.hosting-features.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🎁</span>
                                <span class="text-sm">{{ __('main.features_hostings') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('dashboards-and-systems-read') || auth()->user()->can('dashboards-and-systems-create'))
                        <li class="relative" data-sub-id="dashboards-and-systems" title="{{ __('main.dashboards_and_apps') }}">
                            <a href="{{ route('dashboard.dashboards-and-systems.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.dashboards-and-systems.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🔧</span>
                                <span class="text-sm">{{ __('main.dashboards_and_apps') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->can('platform-management-read') || auth()->user()->can('platform-management-create'))
                        <li class="relative" data-sub-id="platform-management" title="{{ __('main.platform_management') }}">
                            <a href="{{ route('dashboard.platform-management.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.platform-management.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">📱</span>
                                <span class="text-sm">{{ __('main.platform_management') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- Settings --}}
        @if (auth()->user()->can('settings-read'))
            <li class="relative" data-item-id="settings" title="{{ __('main.settings') }}">
                <a href="{{ route('dashboard.settings.index') }}" class="nav-link justify-between {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">⚙️</span>
                        <span class="span-text">{{ limitedText(__('main.settings'), 20) }}</span>
                    </div>

                    <i class="fas fa-arrow-up-right-from-square text-sm nav-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</aside>

@push('scripts')
    <script>
        document.addEventListener('click', function(e) {
            const sidebarLogo = document.querySelector('.sidebar-logo');
            const sidebar = document.getElementById('sidebar');
            const button = e.target.closest('[data-toggle="submenu"]');

            if (button) {
                e.preventDefault();
                e.stopPropagation();

                const submenuItem = button.closest('.submenu-item');
                const submenuList = submenuItem.querySelector('.submenu-list');

                submenuList.classList.toggle('show');
                button.classList.toggle('active');
                return;
            }

            const isLink = e.target.closest('a');
            if (sidebar && sidebar.contains(e.target) && !sidebarLogo.contains(e.target)) {
                document.querySelectorAll('.submenu-list.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.closest('.submenu-item')?.querySelector('[data-toggle="submenu"]')?.classList.remove('active');
                });
            }
        });
    </script>

    {{-- Drag and Drop Functionality --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            /* =========================
                MAIN MENU (Parents)
            ========================= */
            let draggedItem = null;

            document.querySelectorAll('#sidebarMenu > li').forEach(item => {
                item.draggable = true;

                item.addEventListener('dragstart', function() {
                    draggedItem = this;
                    this.classList.add('opacity-50');
                });

                item.addEventListener('dragend', function() {
                    this.classList.remove('opacity-50');
                    draggedItem = null;
                    saveFullOrder();
                });

                item.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    if (!draggedItem || draggedItem === this) return;
                    const rect = this.getBoundingClientRect();
                    const offset = e.clientY - rect.top;
                    const shouldMoveAfter = offset > rect.height / 2;
                    if (shouldMoveAfter && this.nextSibling !== draggedItem) {
                        this.after(draggedItem);
                    } else if (!shouldMoveAfter && this.previousSibling !== draggedItem) {
                        this.before(draggedItem);
                    }
                });
            });

            /* =========================
                SUBMENU (Children)
            ========================= */
            let draggedSub = null;

            const placeholder = document.createElement('li');
            placeholder.className = 'bg-gray-300 my-1 rounded';

            document.querySelectorAll('.submenu-list').forEach(menu => {
                menu.querySelectorAll(':scope > li[data-sub-id]').forEach(item => {
                    item.draggable = true;
                    const link = item.querySelector('a');
                    if (link) link.draggable = false;
                    item.addEventListener('dragstart', function() {
                        draggedSub = this;
                        placeholder.style.height = this.offsetHeight + 'px';
                        this.parentNode.insertBefore(placeholder, this.nextSibling);
                        setTimeout(() => {
                            this.style.display = 'none';
                        }, 0);
                    });

                    item.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        if (!draggedSub || this === draggedSub) return;
                        const rect = this.getBoundingClientRect();
                        const offset = e.clientY - rect.top;
                        const shouldMoveAfter = offset > rect.height / 2;
                        if (shouldMoveAfter) {
                            if (this.nextSibling !== placeholder) {
                                this.after(placeholder);
                            }
                        } else {
                            if (this.previousSibling !== placeholder) {
                                this.before(placeholder);
                            }
                        }
                    });

                    item.addEventListener('dragend', function() {
                        this.style.display = '';
                        if (placeholder.parentNode) {
                            placeholder.replaceWith(this);
                        }
                        draggedSub = null;
                        saveFullOrder();
                    });
                });
            });

            /* =========================
                SAVE ORDER (FULL)
            ========================= */
            function saveFullOrder() {
                let menuOrder = [];
                let submenuOrder = {};

                document.querySelectorAll('#sidebarMenu > li[data-item-id]').forEach((item, index) => {
                    let parentId = item.dataset.itemId;
                    menuOrder.push({
                        id: parentId,
                        order: index
                    });

                    let submenu = item.querySelector('.submenu-list');

                    if (submenu) {
                        submenuOrder[parentId] = [];

                        submenu.querySelectorAll(':scope > li[data-sub-id]').forEach((sub, i) => {
                            submenuOrder[parentId].push({
                                id: sub.dataset.subId,
                                order: i
                            });
                        });
                    }
                });

                fetch("{{ route('dashboard.sidebar.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        menu_order: menuOrder,
                        submenu_order: submenuOrder
                    })
                });
            }
        });
    </script>

    {{-- Fetch and apply saved order on page load --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let sidebarLayout = document.querySelector('#sidebar .layout');
            let sidebar = document.getElementById('sidebarMenu');
            fetch("{{ route('dashboard.sidebar.order') }}")
                .then(res => res.json())
                .then(res => {

                    if (res.status !== 'success') return;

                    sidebarLayout.classList.add('hide');

                    const menuOrder = res.data.menu_order || [];
                    const submenuOrder = res.data.submenu_order || {};

                    const sidebar = document.getElementById('sidebarMenu');

                    /* =========================
                        SORT MAIN MENU
                    ========================= */
                    if (menuOrder.length) {

                        const orderMap = {};
                        menuOrder.forEach(item => {
                            orderMap[item.id] = item.order;
                        });

                        const items = Array.from(
                            sidebar.querySelectorAll(':scope > li[data-item-id]')
                        );

                        items.sort((a, b) => {
                            return (orderMap[a.dataset.itemId] ?? 999) -
                                (orderMap[b.dataset.itemId] ?? 999);
                        });

                        items.forEach(el => sidebar.appendChild(el));
                    }

                    /* =========================
                        SORT SUBMENUS
                    ========================= */
                    Object.keys(submenuOrder).forEach(parentId => {

                        const parent = sidebar.querySelector(`[data-item-id="${parentId}"]`);
                        if (!parent) return;

                        const submenu = parent.querySelector('.submenu-list');
                        if (!submenu) return;

                        const orderMap = {};
                        submenuOrder[parentId].forEach(item => {
                            orderMap[item.id] = item.order;
                        });

                        const items = Array.from(
                            submenu.querySelectorAll(':scope > li[data-sub-id]')
                        );

                        items.sort((a, b) => {
                            return (orderMap[a.dataset.subId] ?? 999) -
                                (orderMap[b.dataset.subId] ?? 999);
                        });

                        items.forEach(el => submenu.appendChild(el));
                    });
                })
                .catch(err => {
                    console.error('Sidebar order fetch error:', err);
                });

        });
    </script>
@endpush
