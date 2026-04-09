<style>
    #topbar-notifications-list {
        &::-webkit-scrollbar {
            width: 4px;
        }

        &::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: var(--color-gray-400);
        }
    }
</style>

<div class="topbar shadow-sm">
    <div class="flex items-center gap-4">
        <!-- Toggle Sidebar Button -->
        <button id="toggleSidebar" class="p-2 cursor-pointer radius-md hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-bars text-xl"></i>
        </button>

        @if (getActiveUser()->role == 'support' && !request()->routeIs('dashboard.index'))
            <a href="{{ route('dashboard.index') }}" class="shineEffect" style="width: calc(var(--width_logo_sidebar) / 1.5) ; margin: auto;">
                <img src="{{ asset('assets/images/website/logo.png') }}" alt="{{ __('main.brand_name') }} {{ __('main.logo') }}">
            </a>
        @endif

        <h2>@yield('page-title')</h2>
    </div>

    <div class="flex items-center gap-6 user-actions">
        <div class="flex items-center gap-3">
            {{-- button go to website --}}
            <a href="{{ route('welcome') }}" target="_blank" class="action-button cursor-pointer p-2 flex items-center justify-center radius-md shadow-sm relative">
                <i class="fas fa-arrow-up-right-from-square text-sm"></i>
            </a>

            <!-- Messages -->
            {{-- <button class="action-button cursor-pointer p-2 flex items-center justify-center radius-md shadow-sm relative">
                <i class="fas fa-envelope text-lg"></i>
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
            </button> --}}

            <!-- Notifications -->
            @php
                $unreadNotifications = auth()->user()?->unreadNotifications ?? collect();
                $unreadCount = $unreadNotifications->count();
            @endphp
            <div class="relative group" id="topbar-notifications">
                <button id="topbar-notifications-button" class="action-button cursor-pointer p-2 flex items-center justify-center radius-md shadow-sm relative">
                    <i class="fas fa-bell text-lg"></i>
                    @if ($unreadCount > 0)
                        <span id="topbar-notifications-badge" class="absolute top-1 right-1 w-2.5 h-2.5 bg-orange-500 rounded-full"></span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div id="topbar-notifications-dropdown" class="hidden absolute mt-2 w-80 bg-white dark:bg-slate-800 radius-md shadow-lg group-hover:opacity-100 z-50">
                    <div class="p-4 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-800 dark:text-white">{{ __('main.notifications') }}</h3>
                        @if ($unreadCount > 0)
                            <form method="POST" action="{{ route('dashboard.notifications.readAll') }}">
                                @csrf
                                <button type="submit" class="cursor-pointer text-xs text-blue-600 dark:text-blue-400 hover:underline">{{ __('main.mark_all_read') }}</button>
                            </form>
                        @endif
                    </div>
                    <div class="max-h-80 overflow-y-auto" id="topbar-notifications-list">
                        @forelse($unreadNotifications as $notification)
                            <form method="POST" action="{{ route('dashboard.notifications.read', $notification->id) }}" class="cursor-pointer">
                                @csrf
                                <button type="submit" class="w-full cursor-pointer text-left block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 w-5 text-center">
                                            @if ($notification->data['type'] === 'new_ticket')
                                                <i class="fas fa-ticket-alt text-blue-500"></i>
                                            @elseif($notification->data['type'] === 'customer_reply')
                                                <i class="fas fa-reply text-green-500"></i>
                                            @else
                                                <i class="fas fa-star text-yellow-500"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 text-start">
                                            <p class="font-medium text-gray-800 dark:text-white text-sm truncate">{{ $notification->data['subject'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $notification->data['body'] }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="mt-2 w-2 h-2 bg-blue-500 rounded-full shrink-0"></span>
                                    </div>
                                </button>
                            </form>
                        @empty
                            <div id="topbar-notifications-empty" class="p-6 text-center text-gray-400 dark:text-gray-500 text-sm">
                                <i class="fas fa-bell-slash text-2xl mx-2 block"></i>
                                {{ __('main.no_new_notifications') }}
                            </div>
                        @endforelse
                    </div>
                    <div class="p-3 border-t border-gray-200 dark:border-slate-700 text-center">
                        <a href="{{ route('dashboard.notifications.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('main.view_all_notifications') }}</a>
                    </div>
                </div>
            </div>

            <!-- Full Screen Toggle -->
            <button id="fullscreenBtn" class="action-button cursor-pointer p-2 flex items-center justify-center radius-md shadow-sm" title="{{ __('main.full_screen') }}">
                <i class="fas fa-expand text-lg"></i>
            </button>

            <!-- Switch Language Toggle -->
            <a href="{{ route('dashboard.locale.change', ['locale' => session('dashboard_locale', 'ar') == 'ar' ? 'en' : 'ar']) }}"
                class="action-button cursor-pointer p-2 radius-md shadow-sm hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300" title="{{ __('main.switch_language') }}">
                <i class="fas fa-language text-lg"></i>
            </a>

            <!-- Dark/Light Mode Toggle -->
            {{-- <button id="themeToggle" class="hidden action-button cursor-pointer p-2 flex items-center justify-center radius-md shadow-sm" title="Toggle Dark Mode">
                <i class="fas fa-sun mode-icon text-lg"></i>
            </button> --}}
        </div>

        <div class="relative">
            <div class="profile">
                <div class="user">
                    <div class="user-name">{{ getActiveUser()?->name ?? __('main.super_admin') }}</div>
                    <p class="user-role">{{ getActiveUser()?->role ?? 'superadmin' }}</p>
                </div>
                <div class="img-box">
                    @if (getActiveUser()?->photo && checkExistFile(getActiveUser()->photo))
                        <img src="{{ asset('storage/' . getActiveUser()->photo) }}" alt="{{ getActiveUser()?->name }}" class="h-32 w-32 rounded">
                    @else
                        @if (getActiveUser())
                            <img src="{{ asset('assets/images/avatars/' . getActiveUser()->photo) }}" class="h-32 w-32 rounded">
                        @else
                            <img src="{{ asset('assets/images/avatar.png') }}" alt="some user image" class="h-32 w-32 rounded">
                        @endif
                    @endif
                </div>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard.myPermissions') }}" class="menu-link">
                            <i class="ph-bold ph-user"></i>
                            {{ __('main.my_permissions') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.profile.show') }}" class="menu-link">
                            <i class="ph-bold ph-user"></i>
                            &nbsp;{{ __('main.my_profile') }}
                        </a>
                    </li>
                    @can('settings-read')
                        <li>
                            <a href="{{ route('dashboard.settings.index') }}" class="menu-link">
                                <i class="ph-bold ph-gear-six"></i>&nbsp;{{ __('main.settings') }}
                            </a>
                        </li>
                    @endcan
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
    const topbarNotificationsButton = document.getElementById('topbar-notifications-button');
    const topbarNotificationsDropdown = document.getElementById('topbar-notifications-dropdown');

    // Toggle Sidebar
    toggleSidebar?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (sidebar) {
            const isOpening = !sidebar.classList.contains('active');

            document.body.style.overflow = isOpening ? 'hidden' : '';
            sidebar.classList.toggle('active', isOpening);
            document.body.classList.toggle('sidebar-closed', isOpening);
            toggleSidebar.classList.toggle('active', isOpening);
        }
    });

    // Toggle Sidebar
    topbarNotificationsButton?.addEventListener('click', () => {
        if (topbarNotificationsDropdown) {
            const isActive = topbarNotificationsDropdown.classList.contains('hidden');
            if (isActive)
                topbarNotificationsDropdown.classList.toggle('hidden');
        }
    });

    document.addEventListener('click', (e) => {
        if (sidebar && toggleSidebar && !sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
            document.body.style.overflow = '';
            sidebar.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar.classList.remove('active');
        }

        if (topbarNotificationsDropdown && !topbarNotificationsDropdown.contains(e.target) && !topbarNotificationsButton.contains(e.target)) {
            topbarNotificationsDropdown.classList.add('hidden');
        }
    });

    // hide notifications dropdown on scroll from my were plus 100
    window.addEventListener('scroll', (e) => {
        if (window.scrollY > 100) {
            const isActive = topbarNotificationsDropdown.classList.contains('hidden');
            if (!isActive)
                topbarNotificationsDropdown.classList.add('hidden');
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

    // Topbar notifications realtime updates via Ably
    document.addEventListener('DOMContentLoaded', function() {
        (() => {
            if (typeof Ably === 'undefined') {
                return;
            }

            const ablyKey = @json(config('app.ably_key'));
            if (!ablyKey) {
                return;
            }

            const csrfToken = @json(csrf_token());
            const notificationsList = document.getElementById('topbar-notifications-list');
            if (!notificationsList) {
                return;
            }

            const customerLabel = @json(__('main.customer'));
            const currentUserId = Number(@json(getActiveUser()->id));
            const markReadBaseUrl = @json(route('dashboard.notifications.read', ['id' => '__ID__']));

            const ensureBadge = (hasUnread) => {
                const button = document.getElementById('topbar-notifications-button');
                if (!button) {
                    return;
                }

                let badge = document.getElementById('topbar-notifications-badge');

                if (!hasUnread) {
                    if (badge) {
                        badge.remove();
                    }
                    return;
                }

                if (!badge) {
                    badge = document.createElement('span');
                    badge.id = 'topbar-notifications-badge';
                    badge.className = 'absolute top-1 right-1 w-2.5 h-2.5 bg-orange-500 rounded-full';
                    button.appendChild(badge);
                }
            };

            const notificationIconHtml = (type) => {
                if (type === 'new_ticket') {
                    return '<i class="fas fa-ticket-alt text-blue-500"></i>';
                }

                if (type === 'customer_reply') {
                    return '<i class="fas fa-reply text-green-500"></i>';
                }

                return '<i class="fas fa-star text-yellow-500"></i>';
            };

            const prependNotification = (payload) => {
                const emptyNode = document.getElementById('topbar-notifications-empty');
                if (emptyNode) {
                    emptyNode.remove();
                }

                const notificationId = payload.notification_id ?? payload.id;
                const wrapper = document.createElement('form');

                if (notificationId) {
                    wrapper.method = 'POST';
                    wrapper.action = markReadBaseUrl.replace('__ID__', notificationId);
                } else {
                    wrapper.method = 'GET';
                    wrapper.action = payload.url || '#';
                }

                wrapper.innerHTML =
                    (notificationId ? '<input type="hidden" name="_token" value="' + csrfToken + '">' : '') +
                    '<button type="submit" class="cursor-pointer w-full text-left block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">' +
                    '<div class="flex items-start gap-3">' +
                    '<div class="mt-0.5 w-5 text-center">' + notificationIconHtml(payload.type) + '</div>' +
                    '<div class="flex-1 min-w-0 text-start">' +
                    '<p class="font-medium text-gray-800 dark:text-white text-sm truncate"></p>' +
                    '<p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"></p>' +
                    '<p class="text-xs text-gray-400 mt-1"></p>' +
                    '</div>' +
                    '<span class="mt-2 w-2 h-2 bg-blue-500 rounded-full shrink-0"></span>' +
                    '</div>' +
                    '</button>';

                const subjectNode = wrapper.querySelector('p:nth-of-type(1)');
                const bodyNode = wrapper.querySelector('p:nth-of-type(2)');
                const dateNode = wrapper.querySelector('p:nth-of-type(3)');

                subjectNode.textContent = payload.subject || customerLabel;
                bodyNode.textContent = payload.body || '';
                dateNode.textContent = payload.created_at_human || @json(__('main.just_now'));

                notificationsList.prepend(wrapper);

                const notificationForms = notificationsList.querySelectorAll('form');
                if (notificationForms.length > 5) {
                    notificationForms[notificationForms.length - 1].remove();
                }
            };

            const realtime = new Ably.Realtime({
                key: ablyKey,
                logLevel: 1,
            });

            const ticketUpdatesChannel = realtime.channels.get('dashboard-notifications');
            ticketUpdatesChannel.subscribe('ticket-notification', (message) => {
                const payload = message?.data || {};

                if (payload.target_user_id && Number(payload.target_user_id) !== currentUserId) {
                    return;
                }

                prependNotification(payload);
                ensureBadge(true);
                window.dispatchEvent(new CustomEvent('dashboard-notification-received', {
                    detail: payload,
                }));
            });
        })();
    });
</script>
