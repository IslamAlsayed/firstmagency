<header id="header" class="header fixed w-full top-0 z-40 background border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Left Side: Logo & Toggle Sidebar -->
        <div class="flex items-center gap-4">
            <!-- Toggle Sidebar Button -->
            <button id="toggleSidebar" class="p-2 cursor-pointer rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Logo/Title -->
            <h1 class="text-xl font-bold text-gray-800 dark:text-white hidden sm:block">
                {{ config('app.name', 'Dashboard') }}
            </h1>
        </div>

        <!-- Right Side: Actions & Icons -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Emails -->
            <div class="relative group">
                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 relative">
                    <i class="fas fa-envelope text-lg"></i>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                </button>

                <!-- Emails Dropdown -->
                <div
                    class="absolute right-0 mt-2 w-72 bg-white dark:bg-slate-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible">
                    <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="font-semibold text-gray-800 dark:text-white">{{ __('dashboard.messages') }}</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <a href="#" class="block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                            <p class="font-medium text-gray-800 dark:text-white text-sm">{{ __('dashboard.new_message') }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('dashboard.welcome_message') }}</p>
                        </a>
                        <a href="#" class="block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                            <p class="font-medium text-gray-800 dark:text-white text-sm">تحديث النظام</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('dashboard.system_update_message') }}</p>
                        </a>
                    </div>
                    <div class="p-3 border-t border-gray-200 dark:border-slate-700 text-center">
                        <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('dashboard.view_all_messages') }}</a>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="relative group">
                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-orange-500 rounded-full"></span>
                </button>

                <!-- Notifications Dropdown -->
                <div
                    class="absolute right-0 mt-2 w-72 bg-white dark:bg-slate-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible">
                    <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="font-semibold text-gray-800 dark:text-white">{{ __('dashboard.notifications') }}</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <a href="#" class="block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                            <p class="font-medium text-gray-800 dark:text-white text-sm">{{ __('dashboard.new_operation') }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('dashboard.operation_added') }}</p>
                        </a>
                        <a href="#" class="block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                            <p class="font-medium text-gray-800 dark:text-white text-sm">{{ __('dashboard.security_alert') }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ __('dashboard.new_login_attempt') }}</p>
                        </a>
                    </div>
                    <div class="p-3 border-t border-gray-200 dark:border-slate-700 text-center">
                        <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('dashboard.view_all_notifications') }}</a>
                    </div>
                </div>
            </div>

            <!-- Full Screen Toggle -->
            <button id="fullscreenBtn" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300" title="Full Screen">
                <i class="fas fa-expand text-lg"></i>
            </button>

            <!-- Dark/Light Mode Toggle -->
            <button id="themeToggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300" title="Toggle Dark Mode">
                <i class="fas fa-sun text-lg dark:hidden"></i>
                <i class="fas fa-moon text-lg hidden dark:inline"></i>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative group">
                <button class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700">
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-sm font-semibold">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <span class="text-gray-800 dark:text-white text-sm font-medium hidden sm:inline">{{ auth()->user()->name ?? 'User' }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-600 dark:text-gray-400 hidden sm:inline"></i>
                </button>

                <!-- Profile Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible">
                    <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                        <p class="font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                    </div>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                        <i class="fas fa-user-circle w-4"></i>
                        <span>{{ __('dashboard.profile') }}</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                        <i class="fas fa-cog w-4"></i>
                        <span>{{ __('dashboard.settings') }}</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                        <i class="fas fa-lock w-4"></i>
                        <span>{{ __('dashboard.change_password') }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200 dark:border-slate-700">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-slate-700">
                            <i class="fas fa-sign-out-alt w-4"></i>
                            <span>{{ __('dashboard.logout') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- JavaScript for Header Functionality -->
<script>
    // Toggle Sidebar
    const toggleBtn = document.getElementById('toggleSidebar');
    toggleBtn.addEventListener('click', () => {
        const sidebar = document.querySelector('aside');
        if (sidebar) {
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-closed');
        }
    });

    // Fullscreen Toggle
    document.getElementById('fullscreenBtn').addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    });

    // Dark Mode Toggle
    document.getElementById('themeToggle').addEventListener('click', () => {
        const html = document.documentElement;
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    // Initialize theme from localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const theme = localStorage.getItem('theme') || 'light';
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    });
</script>
