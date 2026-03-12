<aside id="sidebar" class="sidebar fixed top-0 left-0 bg-gray-900 text-white shadow-lg flex flex-col">
    <div class="sidebar-logo flex items-center justify-between">
        <h4>
            <a href="{{ route('dashboard.index') }}">
                🎛️
                <span>{{ __('main.dashboard') }}</span>
            </a>
        </h4>
        <!-- Close button for small screens -->
        <button id="closeSidebar" class="p-2 rounded-lg hover:bg-slate-700">
            <i class="fas fa-xmark text-xl text-red-600"></i>
        </button>
    </div>

    <ul id="sidebarMenu" class="nav-menu">
        @if (auth()->user()->can('users-read') || auth()->user()->can('users-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">👥</span>
                        <span class="span-text">{{ __('main.users') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.users.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.users.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.user_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.users.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.users.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.user')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Roles -->
        @if (auth()->user()->can('roles-read') || auth()->user()->can('roles-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">🔐</span>
                        <span class="span-text">{{ __('main.roles') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.roles.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.roles.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.roles.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.role_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.roles.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.roles.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.role')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Permissions -->
        @if (auth()->user()->can('permissions-read') || auth()->user()->can('permissions-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">🔑</span>
                        <span class="span-text">{{ __('main.permissions') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.permissions.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.permissions.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.permissions.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.permission_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.permissions.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.permissions.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-file-alt text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.permission')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Articles -->
        @if (auth()->user()->can('articles-read') || auth()->user()->can('articles-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.articles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📝</span>
                        <span class="span-text">{{ __('main.articles') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.articles.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.articles.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.articles.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.article_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.articles.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.articles.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.article')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Services -->
        @if (auth()->user()->can('services-read') || auth()->user()->can('services-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.services.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">💼</span>
                        <span class="span-text">{{ __('main.services') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.services.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.services.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.services.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.service_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.services.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.services.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.service')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Companies -->
        @if (auth()->user()->can('projects-read') || auth()->user()->can('projects-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.projects.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🏢</span>
                        <span class="span-text">{{ __('main.projects') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.projects.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.projects.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.projects.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.projects_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.projects.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.projects.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.company')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Clients -->
        @if (auth()->user()->can('clients-read') || auth()->user()->can('clients-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.clients.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">👥</span>
                        <span class="span-text">{{ __('main.clients') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.clients.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.clients.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.clients.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.clients_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.clients.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.clients.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.client')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Partners -->
        @if (auth()->user()->can('partners-read') || auth()->user()->can('partners-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.partners.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🤝</span>
                        <span class="span-text">{{ __('main.partners') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.partners.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.partners.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.partners.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.partners_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.partners.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.partners.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.partner')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Line Works -->
        @if (auth()->user()->can('line-works-read') || auth()->user()->can('line-works-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.line-works.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">⚙️</span>
                        <span class="span-text">{{ __('main.line_works') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.line-works.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.line-works.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.line-works.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.line_works_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.line-works.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.line-works.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.line_work')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Reviews -->
        @if (auth()->user()->can('reviews-read') || auth()->user()->can('reviews-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.reviews.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">⭐</span>
                        <span class="span-text">{{ __('main.reviews') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.reviews.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.reviews.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.reviews.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.reviews') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.reviews.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.reviews.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.review')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Programming -->
        @if (auth()->user()->can('programmings-read') || auth()->user()->can('programmings-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.programmings.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">💻</span>
                        <span class="span-text">{{ __('main.programmings') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.programmings.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.programmings.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.programmings.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.programmings') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.programmings.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.programmings.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.programming')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- FAQs -->
        @if (auth()->user()->can('faqs-read') || auth()->user()->can('faqs-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.faqs.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">❓</span>
                        <span class="span-text">{{ __('main.faqs') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.faqs.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.faqs.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.faqs.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.faqs') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.faqs.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.faqs.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.faq')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Tickets -->
        @if (auth()->user()->can('tickets-read') || auth()->user()->can('tickets-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.tickets.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🎫</span>
                        <span class="span-text">{{ __('main.tickets') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.tickets.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.tickets.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.tickets.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.tickets') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.tickets.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.tickets.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.ticket')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Our Programming -->
        @if (auth()->user()->can('our-programmings-read') || auth()->user()->can('our-programmings-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.our-programming.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🎫</span>
                        <span class="span-text">{{ __('main.our_programming') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.our-programming.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.our-programmings.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.our-programmings.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.our_programming') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.our-programmings.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.our-programmings.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.our_programming')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Project Steps -->
        @if (auth()->user()->can('project-steps-read') || auth()->user()->can('project-steps-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.project-steps.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📋</span>
                        <span class="span-text">{{ __('main.project_steps') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.project-steps.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.project-steps.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.project-steps.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.project_steps') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.project-steps.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.project-steps.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.project_step')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Features Hosting -->
        @if (auth()->user()->can('features-hosting-read') || auth()->user()->can('features-hosting-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.features-hosting.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🎁</span>
                        <span class="span-text">{{ __('main.features_hostings') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.features-hosting.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.features-hosting.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.features-hosting.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.features_hostings') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.features-hosting.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.features-hosting.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.features_hosting')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Dashboards And Apps -->
        @if (auth()->user()->can('dashboards-and-systems-read') || auth()->user()->can('dashboards-and-systems-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.dashboards-and-systems.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🔧</span>
                        <span class="span-text">{{ __('main.dashboards_and_apps') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.dashboards-and-systems.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.dashboards-and-systems.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.dashboards-and-systems.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.dashboards_and_apps') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.dashboards-and-systems.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.dashboards-and-systems.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.dashboards_and_app')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Hosting Packages -->
        @if (auth()->user()->can('hosting-packages-read') || auth()->user()->can('hosting-packages-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.hosting-packages.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📦</span>
                        <span class="span-text">{{ __('main.hosting_packages') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.hosting-packages.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.hosting-packages.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.hosting-packages.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.hosting_packages') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.hosting-packages.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.hosting-packages.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.hosting_package')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Pest Domains -->
        @if (auth()->user()->can('pest-domains-read') || auth()->user()->can('pest-domains-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.pest-domains.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🌐</span>
                        <span class="span-text">{{ __('main.pest_domains') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.pest-domains.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.pest-domains.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.pest-domains.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.pest_domains_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.pest-domains.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.pest-domains.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.pest_domain')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Official Domains -->
        @if (auth()->user()->can('official-domains-read') || auth()->user()->can('official-domains-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.official-domains.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🌐</span>
                        <span class="span-text">{{ __('main.official_domains') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.official-domains.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.official-domains.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.official-domains.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.official_domains_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.official-domains.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.official-domains.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.official_domain')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Why Us -->
        @if (auth()->user()->can('why-us-read') || auth()->user()->can('why-us-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.why-us.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🌟</span>
                        <span class="span-text">{{ __('main.why_us') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.why-us.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.why-us.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.why-us.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.why_us_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.why-us.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.why-us.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_why_us') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Platform Management -->
        @if (auth()->user()->can('platform-management-read') || auth()->user()->can('platform-management-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.platform-management.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📱</span>
                        <span class="span-text">{{ __('main.platform_management') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.platform-management.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.platform-management.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.platform-management.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.platform_management_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.platform-management.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.platform-management.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_platform_management') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Line Work Step -->
        @if (auth()->user()->can('work-us-step-read') || auth()->user()->can('work-us-step-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.work-us-step.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">👔</span>
                        <span class="span-text">{{ __('main.work_us_step') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.work-us-step.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.work-us-step.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.work-us-step.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.work_us_step_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.work-us-step.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.work-us-step.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_work_us_step') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Marketing Packages -->
        @if (auth()->user()->can('marketing-packages-read') || auth()->user()->can('marketing-packages-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.marketing-packages.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📦</span>
                        <span class="span-text">{{ __('main.marketing_package') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.marketing-packages.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.marketing-packages.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.marketing-packages.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.marketing_package_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.marketing-packages.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.marketing-packages.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_marketing_package') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Settings --}}
        @if (auth()->user()->can('settings-read'))
            <li class="relative">
                <a href="{{ route('dashboard.settings.index') }}"
                    class="nav-link justify-between {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-cog main-icon"></i>
                        <span class="span-text">{{ __('main.settings') }}</span>
                    </div>

                    <i class="fas fa-arrow-up-right-from-square text-sm nav-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</aside>

<script>
    // Submenu Toggle Functionality
    const submenuButtons = document.querySelectorAll('[data-toggle="submenu"]');
    submenuButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            submenuButtons.forEach(button => button.classList.remove('active'));
            // if (button.classList.contains('active')) {
            //     button.classList.remove('active');
            // }
            button.classList.toggle('active');

            const submenuItem = this.closest('.submenu-item');
            const submenuList = submenuItem.querySelector('.submenu-list');
            const isOpen = submenuList.classList.contains('show');

            // Close all open submenus
            document.querySelectorAll('.submenu-list.show').forEach(menu => {
                if (menu !== submenuList) {
                    menu.classList.remove('show');
                }
            });

            // Toggle current submenu
            if (isOpen) {
                submenuList.classList.remove('show');
            } else {
                submenuList.classList.add('show');
            }
        });
    });

    // Scroll to active link
    document.addEventListener('DOMContentLoaded', function() {
        const activeLink = document.querySelector('.nav-link.active');
        if (activeLink) {
            // Get the sidebar container
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                // Scroll to center the active link
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });
</script>
