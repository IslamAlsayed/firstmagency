<div class="topbar">
    <div class="flex items-center gap-4">
        <!-- Toggle Sidebar Button -->
        <button id="toggleSidebar" class="p-2 cursor-pointer rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <h2>@yield('page-title')</h2>
    </div>

    <div class="flex items-center gap-6 user-actions">
        <div class="flex items-center gap-3">
            {{-- button go to website --}}
            <a href="{{ route('welcome') }}" target="_blank" class="action-button cursor-pointer p-2 flex items-center justify-center rounded-lg relative">
                <i class="fas fa-arrow-up-right-from-square text-sm"></i>
            </a>

            <!-- Messages -->
            {{-- <button class="action-button cursor-pointer p-2 flex items-center justify-center rounded-lg relative">
                <i class="fas fa-envelope text-lg"></i>
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
            </button> --}}

            <!-- Notifications -->
            {{-- <button class="action-button cursor-pointer p-2 flex items-center justify-center rounded-lg relative">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-orange-500 rounded-full"></span>
            </button> --}}

            <!-- Full Screen Toggle -->
            <button id="fullscreenBtn" class="action-button cursor-pointer p-2 flex items-center justify-center rounded-lg" title="Full Screen">
                <i class="fas fa-expand text-lg"></i>
            </button>

            <!-- Switch Language Toggle -->
            <a href="{{ route('dashboard.locale.change', ['locale' => session('dashboard_locale', 'ar') == 'ar' ? 'en' : 'ar']) }}"
                class="action-button cursor-pointer p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300" title="Switch Language">
                <i class="fas fa-language text-lg"></i>
            </a>

            <!-- Dark/Light Mode Toggle -->
            {{-- <button id="themeToggle" class="hidden action-button cursor-pointer p-2 flex items-center justify-center rounded-lg" title="Toggle Dark Mode">
                <i class="fas fa-sun mode-icon text-lg"></i>
            </button> --}}

            <!-- Account Switcher -->
            @include('dashboard.components.account-switcher', ['availableUsers' => \App\Models\User::all()])
        </div>

        <div class="relative">
            <div class="profile">
                <div class="user">
                    <div class="user-name">{{ getActiveUser()?->name ?? 'Super Admin' }}</div>
                    <p class="user-role {{ getActiveUser()?->role ?? 'superadmin' }}">{{ getActiveUser()?->role ?? 'superadmin' }}</p>
                </div>
                <div class="img-box">
                    @if (getActiveUser())
                        <img src="{{ asset('assets/images/avatars/' . getActiveUser()->photo) }}" class="h-32 w-32 rounded">
                    @else
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="some user image">
                    @endif
                </div>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard.roles.show', getActiveUserId()) }}" class="menu-link">
                            <i class="ph-bold ph-user"></i>
                            {{ __('main.my_roles_and_permissions') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.profile.show') }}" class="menu-link">
                            <i class="ph-bold ph-user"></i>
                            &nbsp;{{ __('main.my_profile') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.profile.edit') }}" class="menu-link">
                            <i class="ph-bold ph-pencil"></i>
                            &nbsp;{{ __('main.edit_profile') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.profile.activity') }}" class="menu-link">
                            <i class="ph-bold ph-clock"></i>
                            &nbsp;{{ __('main.activity') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.settings.index') }}" class="menu-link">
                            <i class="ph-bold ph-gear-six"></i>&nbsp;{{ __('main.settings') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="">
                            @csrf
                            <button type="submit" class="menu-link w-full h-full cursor-pointer">
                                <i class="ph-bold ph-sign-out"></i>
                                &nbsp;{{ __('main.sign_out') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    // Toggle Sidebar
    toggleSidebar?.addEventListener('click', () => {
        if (sidebar) {
            const isActive = sidebar.classList.contains('active');

            document.body.style.overflow = isActive ? '' : 'hidden';
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-closed');
            toggleSidebar.classList.toggle('active');
        }
    });

    document.addEventListener('click', (e) => {
        if (sidebar && !sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
            document.body.style.overflow = '';
            sidebar.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar.classList.remove('active');
        }
    });

    // Close Sidebar button for small screens
    closeSidebar?.addEventListener('click', () => {
        console.log('close');
        if (sidebar) {
            document.body.style.overflow = '';
            sidebar.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar.classList.remove('active');
        }
    });

    // Fullscreen Toggle
    document.getElementById('fullscreenBtn')?.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    });

    // Dark Mode Toggle
    document.getElementById('themeToggle')?.addEventListener('click', () => {
        const html = document.documentElement;
        html.classList.toggle('dark');
        document.querySelector('.mode-icon').classList.toggle('fa-sun');
        document.querySelector('.mode-icon').classList.toggle('fa-moon');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    // Initialize theme from localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const theme = localStorage.getItem('theme') || 'light';
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.querySelector('.mode-icon')?.classList.add('fa-moon');
            document.querySelector('.mode-icon')?.classList.remove('fa-sun');
        }

        // Initialize sidebar state
        if (sidebar) {
            sidebar?.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar?.classList.remove('active');
        }
    });

    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            sidebar?.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar?.classList.remove('active');
        });
    } else {
        // Initialize sidebar state
        if (sidebar) {
            sidebar?.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar?.classList.remove('active');
        }
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        // Initialize sidebar state
        if (sidebar) {
            sidebar?.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar?.classList.remove('active');
        }
    });

    // Profile Menu Toggle
    const profile = document.querySelector('.profile');
    const menu = document.querySelector('.menu');

    if (profile && menu) {
        profile.addEventListener('click', () => {
            menu.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!profile.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('active');
            }
        });
    }
</script>
