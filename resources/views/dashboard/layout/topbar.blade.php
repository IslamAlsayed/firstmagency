<style>
    /* ── Scrollbar ─────────────────────────────────────────────────── */
    #topbar-notifications-list {
        &::-webkit-scrollbar       { width: 4px; }
        &::-webkit-scrollbar-thumb { border-radius: 4px; background-color: var(--color-gray-400); }
    }

    /* ── Top accent line ────────────────────────────────────────────── */
    .topbar { border-top: 3px solid var(--dash_primary_color); }

    /* ── Date chip ─────────────────────────────────────────────────── */
    .topbar-date-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--icon_color);
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--hover-light-1);
        border: 1px solid var(--hover-light-2);
        white-space: nowrap;
        flex-shrink: 0;
        user-select: none;
    }

    /* ── Actions pill ───────────────────────────────────────────────── */
    .topbar-actions-pill {
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 4px;
        border-radius: 14px;
        background: var(--hover-light-1);
        border: 1px solid var(--hover-light-2);
    }

    /* ── Divider ────────────────────────────────────────────────────── */
    .topbar-divider {
        width: 1px;
        height: 28px;
        flex-shrink: 0;
        border-radius: 1px;
        background: var(--hover-light-2);
    }

    /* ── Notification badge (number) ────────────────────────────────── */
    #topbar-notifications-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        min-width: 17px;
        height: 17px;
        padding: 0 3px;
        border-radius: 20px;
        background: #f97316;
        color: #fff;
        font-size: 9px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        border: 2px solid var(--light-color);
        pointer-events: none;
    }

    /* ── Dropdown fade-in ───────────────────────────────────────────── */
    #topbar-notifications-dropdown:not(.hidden) {
        animation: tbDropIn 0.17s ease;
    }

    @keyframes tbDropIn {
        from { opacity: 0; transform: translateY(-7px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    /* ── Responsive ─────────────────────────────────────────────────── */
    @media (max-width: 576px) {
        .topbar-date-chip { display: none; }
        .topbar-divider   { display: none; }
    }
</style>

<div class="topbar shadow-sm">

    {{-- ── Left: toggle + title + date ──────────────────────────────── --}}
    <div class="flex items-center gap-3" style="min-width:0; flex:1;">

        <button id="toggleSidebar"
                class="p-2 cursor-pointer radius-md hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300"
                aria-label="Toggle sidebar">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <h2 class="truncate" style="margin:0; flex:1; min-width:0;">@yield('page-title')</h2>

        {{-- Live date chip --}}
        <span class="topbar-date-chip" aria-live="polite">
            <i class="far fa-calendar-alt" style="font-size:.65rem;"></i>
            <span id="topbar-live-date"></span>
        </span>
    </div>

    {{-- ── Right: actions pill + divider + profile ──────────────────── --}}
    <div class="flex items-center gap-3 user-actions" style="flex-shrink:0;">

        {{-- Actions pill --}}
        <div class="topbar-actions-pill">

            {{-- Visit website --}}
            <a href="{{ route('welcome') }}" target="_blank" rel="noopener"
               class="action-button cursor-pointer p-2 flex items-center justify-center radius-md relative"
               title="{{ __('main.visit_website') ?? 'Visit website' }}">
                <i class="fas fa-arrow-up-right-from-square text-sm"></i>
            </a>

            {{-- Notifications --}}
            @php
                $unreadNotifications = auth()->user()?->unreadNotifications ?? collect();
                $unreadCount         = $unreadNotifications->count();
            @endphp

            <div class="relative" id="topbar-notifications">
                <button id="topbar-notifications-button"
                        class="action-button cursor-pointer p-2 flex items-center justify-center radius-md relative"
                        title="{{ __('main.notifications') }}"
                        aria-label="{{ __('main.notifications') }}">
                    <i class="fas fa-bell text-lg"></i>
                    @if ($unreadCount > 0)
                        <span id="topbar-notifications-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>

                {{-- Dropdown --}}
                <div id="topbar-notifications-dropdown"
                     class="hidden absolute mt-2 w-80 bg-white dark:bg-slate-800 radius-md shadow-lg z-50"
                     style="inset-inline-end:0; inset-inline-start:auto;">

                    {{-- Header --}}
                    <div class="p-4 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-bell text-sm" style="color:var(--dash_primary_color);"></i>
                            <h3 class="font-semibold text-gray-800 dark:text-white text-sm">{{ __('main.notifications') }}</h3>
                            @if ($unreadCount > 0)
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full text-white"
                                      style="background:var(--dash_primary_color);">{{ $unreadCount }}</span>
                            @endif
                        </div>
                        @if ($unreadCount > 0)
                            <form method="POST" action="{{ route('dashboard.notifications.readAll') }}">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('main.mark_all_read') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- List --}}
                    <div class="max-h-80 overflow-y-auto" id="topbar-notifications-list">
                        @forelse($unreadNotifications as $notification)
                            <form method="POST" action="{{ route('dashboard.notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full cursor-pointer text-left block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                             style="background:var(--hover-light-1);">
                                            @if ($notification->data['type'] === 'new_ticket')
                                                <i class="fas fa-ticket-alt text-blue-500 text-xs"></i>
                                            @elseif ($notification->data['type'] === 'customer_reply')
                                                <i class="fas fa-reply text-green-500 text-xs"></i>
                                            @else
                                                <i class="fas fa-star text-yellow-500 text-xs"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 text-start">
                                            <p class="font-medium text-gray-800 dark:text-white text-sm truncate">
                                                {{ $notification->data['subject'] }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                                {{ $notification->data['body'] }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                                <i class="far fa-clock" style="font-size:.6rem;"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="mt-2 w-2 h-2 rounded-full flex-shrink-0"
                                              style="background:var(--dash_primary_color);"></span>
                                    </div>
                                </button>
                            </form>
                        @empty
                            <div id="topbar-notifications-empty" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                <i class="fas fa-bell-slash text-3xl block mb-2" style="opacity:.4;"></i>
                                <p class="text-sm font-semibold">{{ __('main.no_new_notifications') }}</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Footer --}}
                    <div class="p-3 border-t border-gray-200 dark:border-slate-700 text-center">
                        <a href="{{ route('dashboard.notifications.index') }}"
                           class="text-sm font-semibold hover:underline"
                           style="color:var(--dash_primary_color);">
                            {{ __('main.view_all_notifications') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Fullscreen --}}
            <button id="fullscreenBtn"
                    class="action-button cursor-pointer p-2 flex items-center justify-center radius-md"
                    title="{{ __('main.full_screen') }}">
                <i class="fas fa-expand text-lg" id="fullscreen-icon"></i>
            </button>

            {{-- Language switch --}}
            <a href="{{ route('dashboard.locale.change', ['locale' => session('dashboard_locale', 'ar') == 'ar' ? 'en' : 'ar']) }}"
               class="action-button cursor-pointer p-2 radius-md text-gray-700 dark:text-gray-300"
               title="{{ __('main.switch_language') }}">
                <i class="fas fa-language text-lg"></i>
            </a>
        </div>

        {{-- Divider --}}
        <div class="topbar-divider" aria-hidden="true"></div>

        {{-- Profile --}}
        <div class="relative">
            <div class="profile">
                <div class="user">
                    <div class="user-name">{{ getActiveUser()?->name ?? __('main.super_admin') }}</div>
                    <p class="user-role {{ getActiveUser()?->role ?? 'superadmin' }}">{{ getActiveUser()?->role ?? 'superadmin' }}</p>
                </div>
                <div class="img-box">
                    @if (getActiveUser()?->photo && checkExistFile(getActiveUser()->photo))
                        <img src="{{ asset('storage/' . getActiveUser()->photo) }}"
                             alt="{{ getActiveUser()?->name }}" class="h-full w-full">
                    @elseif (getActiveUser())
                        <img src="{{ asset('assets/images/avatars/' . getActiveUser()->photo) }}"
                             class="h-full w-full">
                    @else
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="avatar" class="h-full w-full">
                    @endif
                </div>
            </div>
            <div class="menu">
                <ul>
                    <li>
                        <a href="{{ route('dashboard.roles.show', getActiveUserId()) }}" class="menu-link">
                            <i class="ph-bold ph-shield-check"></i>
                            {{ __('main.my_roles_and_permissions') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.profile.show') }}" class="menu-link">
                            <i class="ph-bold ph-user"></i>
                            {{ __('main.my_profile') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.settings.index') }}" class="menu-link">
                            <i class="ph-bold ph-gear-six"></i>
                            {{ __('main.settings') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-link w-full h-full cursor-pointer">
                                <i class="ph-bold ph-sign-out"></i>
                                {{ __('main.sign_out') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>

    // ── Sidebar toggle ─────────────────────────────────────────────────
    toggleSidebar?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!sidebar) return;
        const opening = !sidebar.classList.contains('active');
        document.body.style.overflow = opening ? 'hidden' : '';
        sidebar.classList.toggle('active', opening);
        document.body.classList.toggle('sidebar-closed', opening);
        toggleSidebar.classList.toggle('active', opening);
    });

    closeSidebar?.addEventListener('click', () => {
        if (!sidebar) return;
        document.body.style.overflow = '';
        sidebar.classList.remove('active');
        document.body.classList.remove('sidebar-closed');
        toggleSidebar?.classList.remove('active');
    });

    window.addEventListener('resize', () => {
        if (!sidebar) return;
        document.body.style.overflow = '';
        sidebar.classList.remove('active');
        document.body.classList.remove('sidebar-closed');
        toggleSidebar?.classList.remove('active');
    });

    // ── Notifications dropdown ─────────────────────────────────────────
    topbarNotificationsButton?.addEventListener('click', (e) => {
        e.stopPropagation();
        topbarNotificationsDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (sidebar && toggleSidebar &&
            !sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
            document.body.style.overflow = '';
            sidebar.classList.remove('active');
            document.body.classList.remove('sidebar-closed');
            toggleSidebar.classList.remove('active');
        }
        if (topbarNotificationsDropdown &&
            !topbarNotificationsDropdown.contains(e.target) &&
            !topbarNotificationsButton?.contains(e.target)) {
            topbarNotificationsDropdown.classList.add('hidden');
        }
    });

    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) topbarNotificationsDropdown?.classList.add('hidden');
    });

    // ── Fullscreen toggle ──────────────────────────────────────────────
    document.getElementById('fullscreenBtn')?.addEventListener('click', () => {
        const icon = document.getElementById('fullscreen-icon');
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(() => {});
            icon?.classList.replace('fa-expand', 'fa-compress');
        } else {
            document.exitFullscreen();
            icon?.classList.replace('fa-compress', 'fa-expand');
        }
    });

    // ── Profile menu ───────────────────────────────────────────────────
    const profile = document.querySelector('.profile');
    const menu    = document.querySelector('.menu');

    if (profile && menu) {
        profile.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('active');
        });
        document.addEventListener('click', (e) => {
            if (!profile.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('active');
            }
        });
    }

    // ── Live date chip ─────────────────────────────────────────────────
    function updateLiveDate() {
        const el = document.getElementById('topbar-live-date');
        if (!el) return;
        const lang = document.documentElement.lang || 'ar';
        el.textContent = new Date().toLocaleDateString(
            lang === 'ar' ? 'ar-EG' : 'en-GB',
            { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' }
        );
    }
    updateLiveDate();
    setInterval(updateLiveDate, 60_000);

    // ── Init sidebar on load ───────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        sidebar?.classList.remove('active');
        document.body.classList.remove('sidebar-closed');
        toggleSidebar?.classList.remove('active');
    });

    // ── Realtime notifications (Ably) ──────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        (() => {
            if (typeof Ably === 'undefined') return;

            const ablyKey = @json(config('app.ably_key'));
            if (!ablyKey) return;

            const csrfToken         = @json(csrf_token());
            const notificationsList = document.getElementById('topbar-notifications-list');
            if (!notificationsList) return;

            const customerLabel   = @json(__('main.customer'));
            const markReadBaseUrl = @json(route('dashboard.notifications.read', ['id' => '__ID__']));
            const justNowLabel    = @json(__('main.just_now'));

            // Track live unread count from initial badge
            let liveCount = parseInt(
                document.getElementById('topbar-notifications-badge')?.textContent || '0', 10
            );

            const updateBadge = (delta) => {
                liveCount = Math.max(0, liveCount + delta);
                const button = document.getElementById('topbar-notifications-button');
                if (!button) return;
                let badge = document.getElementById('topbar-notifications-badge');
                if (liveCount === 0) { badge?.remove(); return; }
                if (!badge) {
                    badge = document.createElement('span');
                    badge.id = 'topbar-notifications-badge';
                    button.appendChild(badge);
                }
                badge.textContent = liveCount > 9 ? '9+' : String(liveCount);
            };

            const notificationIconHtml = (type) => {
                if (type === 'new_ticket')     return '<i class="fas fa-ticket-alt text-blue-500 text-xs"></i>';
                if (type === 'customer_reply') return '<i class="fas fa-reply text-green-500 text-xs"></i>';
                return '<i class="fas fa-star text-yellow-500 text-xs"></i>';
            };

            const prependNotification = (payload) => {
                document.getElementById('topbar-notifications-empty')?.remove();

                const notificationId = payload.id ?? payload.notification_id;
                const wrapper = document.createElement('form');
                if (notificationId) {
                    wrapper.method = 'POST';
                    wrapper.action = markReadBaseUrl.replace('__ID__', notificationId);
                } else {
                    wrapper.method = 'GET';
                    wrapper.action = payload.url || '#';
                }

                wrapper.innerHTML =
                    (notificationId ? `<input type="hidden" name="_token" value="${csrfToken}">` : '') +
                    `<button type="submit" class="w-full text-left block p-4 hover:bg-gray-50 dark:hover:bg-slate-700 border-b border-gray-100 dark:border-slate-700">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background:var(--hover-light-1);">
                                ${notificationIconHtml(payload.type)}
                            </div>
                            <div class="flex-1 min-w-0 text-start">
                                <p class="font-medium text-gray-800 dark:text-white text-sm truncate"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"></p>
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <i class="far fa-clock" style="font-size:.6rem;"></i>
                                    <span></span>
                                </p>
                            </div>
                            <span class="mt-2 w-2 h-2 rounded-full flex-shrink-0"
                                  style="background:var(--dash_primary_color);"></span>
                        </div>
                    </button>`;

                wrapper.querySelector('p:nth-of-type(1)').textContent = payload.subject || customerLabel;
                wrapper.querySelector('p:nth-of-type(2)').textContent = payload.body || '';
                wrapper.querySelector('p:nth-of-type(3) span').textContent = payload.created_at_human || justNowLabel;

                notificationsList.prepend(wrapper);
                const forms = notificationsList.querySelectorAll('form');
                if (forms.length > 5) forms[forms.length - 1].remove();
            };

            const realtime = new Ably.Realtime({ key: ablyKey, logLevel: 1 });
            const channel  = realtime.channels.get('dashboard-notifications');

            channel.subscribe('ticket-notification', (message) => {
                const payload = message?.data || {};
                prependNotification(payload);
                updateBadge(+1);
            });
        })();
    });
</script>
