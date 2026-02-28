<aside id="sidebar" class="sidebar fixed top-0 left-0  bg-gray-900 text-white shadow-lg flex flex-col">
    <div class="sidebar-logo">
        <h4>
            <a href="{{ route('dashboard.index') }}">
                🎛️
                <span>{{ __('dashboard.dashboard') }}</span>
            </a>
        </h4>
    </div>

    <ul id="sidebarMenu" class="nav-menu">
        <!-- Submenu Example -->
        <li class="relative group submenu-item">
            <button type="button" data-toggle="submenu"
                class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                    <span class="main-icon">👥</span>
                    <span>{{ __('dashboard.users') }}</span>
                </div>
                <i class="fas fa-chevron-down text-xs group-hover:rotate-180"></i>
            </button>

            <!-- عناصر القائمة الفرعية -->
            <ul
                class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.users.*') ? 'show' : '' }}">
                <li class="relative">
                    <a href="{{ route('dashboard.users.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.user_list') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="{{ route('dashboard.users.create') }}"
                        class="nav-link {{ request()->routeIs('dashboard.users.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.create_user') }}</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Roles -->
        <li class="relative group submenu-item">
            <button type="button" data-toggle="submenu"
                class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                    <span class="main-icon">🔐</span>
                    <span>{{ __('dashboard.roles') }}</span>
                </div>
                <i class="fas fa-chevron-down text-xs group-hover:rotate-180"></i>
            </button>

            <!-- عناصر القائمة الفرعية -->
            <ul
                class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.roles.*') ? 'show' : '' }}">
                <li class="relative">
                    <a href="{{ route('dashboard.roles.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.roles.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.role_list') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="{{ route('dashboard.roles.create') }}"
                        class="nav-link {{ request()->routeIs('dashboard.roles.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.create_role') }}</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Permissions -->
        <li class="relative group submenu-item">
            <button type="button" data-toggle="submenu"
                class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    {{-- <i class="fas fa-folder-open main-icon"></i> --}}
                    <span class="main-icon">🔑</span>
                    <span>{{ __('dashboard.permissions') }}</span>
                </div>
                <i class="fas fa-chevron-down text-xs group-hover:rotate-180"></i>
            </button>

            <!-- عناصر القائمة الفرعية -->
            <ul
                class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.permissions.*') ? 'show' : '' }}">
                <li class="relative">
                    <a href="{{ route('dashboard.permissions.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.permissions.index') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.permission_list') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="{{ route('dashboard.permissions.create') }}"
                        class="nav-link {{ request()->routeIs('dashboard.permissions.create') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.create_permission') }}</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="relative">
            <a href="{{ route('dashboard.settings.index') }}" class="nav-link justify-between {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-cog main-icon"></i>
                    <span>{{ __('dashboard.settings') }}</span>
                </div>

                <i class="fas fa-arrow-up-right-from-square"></i>
            </a>
        </li>

        <!-- Submenu Example -->
        <li class="relative group submenu-item hidden">
            <button type="button" data-toggle="submenu"
                class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover:bg-slate-800 {{ request()->routeIs('dashboard.content.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-folder-open main-icon"></i>
                    <span>{{ __('dashboard.content') }}</span>
                </div>
                <i class="fas fa-chevron-down text-xs group-hover:rotate-180"></i>
            </button>

            <!-- Submenu Items -->
            <ul
                class="submenu-list group-hover:block bg-slate-800 rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.content.*') ? 'show' : '' }}">
                <li class="relative">
                    <a href="#"
                        class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-file-alt text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.articles') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="#"
                        class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-images text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.images') }}</span>
                    </a>
                </li>
                <li class="relative">
                    <a href="#"
                        class="nav-link flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                        <i class="fas fa-video text-sm main-icon"></i>
                        <span class="text-sm">{{ __('dashboard.videos') }}</span></span>
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
