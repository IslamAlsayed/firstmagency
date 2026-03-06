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
            <i class="fas fa-xmark text-xl"></i>
        </button>
    </div>

    <ul id="sidebarMenu" class="nav-menu">
        @if (auth()->user()->can('users-read') || auth()->user()->can('users-create'))
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">👥</span>
                        <span>{{ __('main.users') }}</span>
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
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">🔐</span>
                        <span>{{ __('main.roles') }}</span>
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
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">🔑</span>
                        <span>{{ __('main.permissions') }}</span>
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
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.articles.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">📝</span>
                        <span>{{ __('main.articles') }}</span>
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
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.services.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">💼</span>
                        <span>{{ __('main.services') }}</span>
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
        @if (auth()->user()->can('companies-read') || auth()->user()->can('companies-create'))
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.companies.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">🏢</span>
                        <span>{{ __('main.companies') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs nav-icon"></i>
                </button>

                <ul
                    class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.companies.*') ? 'show' : '' }}">
                    <li class="relative">
                        <a href="{{ route('dashboard.companies.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.companies.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-list text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.companies_list') }}</span>
                        </a>
                    </li>
                    <li class="relative">
                        <a href="{{ route('dashboard.companies.create') }}"
                            class="nav-link {{ request()->routeIs('dashboard.companies.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                            <i class="fas fa-plus text-sm main-icon"></i>
                            <span class="text-sm">{{ __('main.create_type', ['type' => __('main.company')]) }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <!-- Clients -->
        @if (auth()->user()->can('clients-read') || auth()->user()->can('clients-create'))
            <li class="relative group submenu-item hidden">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.clients.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">👥</span>
                        <span>{{ __('main.clients') }}</span>
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
                        <span>{{ __('main.partners') }}</span>
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

        <!-- LineWorks -->
        @if (auth()->user()->can('line-works-read') || auth()->user()->can('line-works-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.line-works.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="main-icon">⚙️</span>
                        <span>{{ __('main.line_works') }}</span>
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
                        <span>{{ __('main.reviews') }}</span>
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
                        <span>{{ __('main.programmings') }}</span>
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
                        <span>{{ __('main.faqs') }}</span>
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
                        <span>{{ __('main.tickets') }}</span>
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

        {{-- Settings --}}
        @if (auth()->user()->can('settings-read'))
            <li class="relative">
                <a href="{{ route('dashboard.settings.index') }}"
                    class="nav-link justify-between {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-cog main-icon"></i>
                        <span>{{ __('main.settings') }}</span>
                    </div>

                    <i class="fas fa-arrow-up-right-from-square text-sm nav-icon"></i>
                </a>
            </li>
        @endif

        <li class="relative group submenu-item hidden">
            <button type="button" data-toggle="submenu"
                class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.content.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-folder-open main-icon"></i>
                    <span>{{ __('main.content') }}</span>
                </div>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>

            <ul
                class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.content.*') ? 'show' : '' }}">
                <li class="relative">
                    <a href="{{ route('dashboard.articles.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.articles.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('main.articles') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="#"
                        class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-images text-sm main-icon"></i>
                        <span class="text-sm">{{ __('main.images') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="#"
                        class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-video text-sm main-icon"></i>
                        <span class="text-sm">{{ __('main.videos') }}</span></span>
                    </a>
                </li>
            </ul>
        </li>
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
