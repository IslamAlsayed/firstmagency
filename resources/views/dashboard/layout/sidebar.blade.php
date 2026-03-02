<aside id="sidebar" class="sidebar fixed top-0 left-0 bg-gray-900 text-white shadow-lg flex flex-col">
    <div class="sidebar-logo">
        <h4>
            <a href="{{ route('dashboard.index') }}">
                🎛️
                <span>{{ __('main.dashboard') }}</span>
            </a>
        </h4>
    </div>

    <ul id="sidebarMenu" class="nav-menu">
        @if (auth()->user()->can('users-read') || auth()->user()->can('users-create'))
            <li class="relative group submenu-item">
                <button type="button" data-toggle="submenu"
                    class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                        <span class="main-icon">👥</span>
                        <span>{{ __('main.users') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
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
                            <span class="text-sm">{{ __('main.create_user') }}</span>
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
                        <span>{{ __('main.roles') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
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
                            <span class="text-sm">{{ __('main.create_role') }}</span>
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
                        <span>{{ __('main.permissions') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
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
                            <span class="text-sm">{{ __('main.create_permission') }}</span>
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
                        <span>{{ __('main.articles') }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs"></i>
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
                            <span class="text-sm">{{ __('main.create_article') }}</span>
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

                    <i class="fas fa-arrow-up-right-from-square"></i>
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
    document.querySelectorAll('[data-toggle="submenu"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
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

    // Add CSS for show class
    // const style = document.createElement('style');
    // style.textContent = `
    //     .submenu-list.show {
    //         display: block !important;
    //     }
    // `;
    // document.head.appendChild(style);
</script>
