@extends('dashboard.layout.master')

@section('title', __('main.notifications'))
@section('page-title', '🔔 ' . __('main.notifications'))

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <div id="bulk-delete-form">
            @csrf
            @method('DELETE')
            <div class="notifications-header flex items-center justify-between gap-4 pb-4 flex-wrap border-b border-gray-300">
                <h3 class="kt-card-title">{{ __('main.notifications') }}</h3>
                <div class="flex gap-2">
                    {{-- @if (auth()->user()->unreadNotifications->count() > 0)
                        <form method="POST" action="{{ route('dashboard.notifications.readAll') }}">
                            @csrf
                            <button type="submit" class="kt-btn kt-btn-outline-primary text-sm" toggle-button>
                                <i class="fas fa-check-double me-1"></i>
                                {{ __('main.mark_all_read') }}
                            </button>
                        </form>
                    @endif --}}
                    @if (auth()->user()->notifications->count() > 0)
                        <!-- Delete All Form -->
                        <form id="delete_all_form" method="POST" action="{{ route('dashboard.notifications.destroyAll') }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" id="delete_all" class="kt-btn bg-danger text-sm hidden" toggle-button onclick="return confirm('{{ __('main.are_you_sure') }}');"><i
                                    class="fas fa-trash me-1"></i>
                                {{ __('main.delete_all') }}</button>
                        </form>
                        <!-- Delete Selected Form -->
                        <form id="delete_selected_form" method="POST" action="{{ route('dashboard.notifications.destroyAll') }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" id="delete_selected" class="kt-btn bg-danger text-sm hidden" toggle-button onclick="return confirm('{{ __('main.are_you_sure') }}');"><i
                                    class="fas fa-trash me-1"></i>
                                {{ __('main.delete_selected') }}</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="notifications-content" id="notifications-page-list">
                @forelse($notifications as $notification)
                    <div class="flex items-start gap-4 p-4 {{ !$loop->last ? 'border-b border-gray-300' : '' }} {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }} hover:bg-gray-50 transition">
                        <div class="mt-2">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="" value="">
                                @include('dashboard.components.checkbox-button', [
                                    'name' => 'selected_notifications[]',
                                    'id' => 'notification_' . $notification->id,
                                    'value' => $notification->id,
                                    'classes' => 'notification-checkbox',
                                ])
                            </div>
                        </div>
                        <div class="text-xl mt-1 shrink-0 w-8 text-center">
                            @if ($notification->data['type'] === 'new_ticket')
                                <i class="fas fa-ticket-alt text-blue-500"></i>
                            @elseif($notification->data['type'] === 'customer_reply')
                                <i class="fas fa-reply text-green-500"></i>
                            @else
                                <i class="fas fa-star text-yellow-500"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-600 text-sm">
                                {{ $notification->data['subject'] }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-600 mt-0.5">
                                {{ $notification->data['body'] }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                                @if ($notification->read_at)
                                    &bull; <span class="text-gray-600">{{ __('main.notification_read_status') }}</span>
                                @else
                                    &bull; <span class="text-blue-500 font-medium">{{ __('main.notification_new_status') }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <form method="POST" action="{{ route('dashboard.notifications.read', $notification->id) }}" class="inline-block">
                                @csrf
                                <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline-primary text-xs" toggle-button>
                                    @if (getActiveUser()->button_display_mode === 'text')
                                        {!! __('main.notification_open_action') !!}
                                    @elseif (getActiveUser()->button_display_mode === 'icon')
                                        <i class="fas fa-external-link-alt text-white"></i>
                                    @else
                                        <i class="fas fa-external-link-alt text-white"></i>
                                        {!! __('main.notification_open_action') !!}
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.notifications.destroy', $notification->id) }}" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="kt-btn kt-btn-sm bg-danger text-xs" toggle-button>
                                    @if (getActiveUser()->button_display_mode === 'text')
                                        {!! __('main.delete') !!}
                                    @elseif (getActiveUser()->button_display_mode === 'icon')
                                        <i class="fas fa-trash text-white"></i>
                                    @else
                                        <i class="fas fa-trash text-white"></i>
                                        {!! __('main.delete') !!}
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div id="notifications-empty-state" class="p-8 text-center text-gray-600 dark:text-gray-600">
                        <i class="fas fa-bell-slash text-4xl mb-3 block"></i>
                        <p>{{ __('main.no_notifications') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        @if ($notifications->hasPages())
            <div class="kt-card-footer p-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Select/Deselect all checkboxes and handle delete selected
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.notifications-header');
            const deleteAllBtn = document.getElementById('delete_all');
            const deleteSelectedBtn = document.getElementById('delete_selected');
            const deleteSelectedForm = document.getElementById('delete_selected_form');
            const selectedInput = document.getElementById('selected_notifications_input');

            function updateDeleteButtons() {
                const checked = document.querySelectorAll('.notification-checkbox:checked').length;
                if (checked > 0) {
                    if (deleteAllBtn) deleteAllBtn.classList.add('hidden');
                    if (deleteSelectedBtn) deleteSelectedBtn.classList.remove('hidden');
                } else {
                    if (deleteAllBtn) deleteAllBtn.classList.remove('hidden');
                    if (deleteSelectedBtn) deleteSelectedBtn.classList.add('hidden');
                }
                if (deleteAllBtn) deleteAllBtn.classList.add('hidden');
                if (deleteSelectedBtn) deleteSelectedBtn.classList.add('hidden');
                if (checked > 0) {
                    if (deleteSelectedBtn) deleteSelectedBtn.classList.remove('hidden');
                }
            }

            function bindNotificationCheckboxes() {
                document.querySelectorAll('.notification-checkbox').forEach(cb => {
                    cb.removeEventListener('change', updateDeleteButtons);
                    cb.addEventListener('change', updateDeleteButtons);
                });
            }

            bindNotificationCheckboxes();
            if (header && document.querySelectorAll('.notification-checkbox').length > 0) {
                const selectAllDiv = document.createElement('div');
                selectAllDiv.className = 'custom-input';
                selectAllDiv.style.marginRight = '8px';
                const selectAll = document.createElement('input');
                selectAll.type = 'checkbox';
                selectAll.id = 'select_all_notifications';
                selectAll.className = 'notification-checkbox';
                selectAll.title = '{{ __('main.select_all') }}';
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.notification-checkbox').forEach(cb => {
                        if (cb !== selectAll) cb.checked = selectAll.checked;
                    });
                    updateDeleteButtons();
                });
                const label = document.createElement('label');
                label.setAttribute('for', 'select_all_notifications');
                label.innerText = '{{ __('main.select_all') }}';
                selectAllDiv.appendChild(selectAll);
                selectAllDiv.appendChild(label);
                header.prepend(selectAllDiv);
            }
            updateDeleteButtons();

            // Handle delete selected form submission
            if (deleteSelectedForm) {
                deleteSelectedForm.addEventListener('submit', function(e) {
                    // Remove any old hidden inputs
                    deleteSelectedForm.querySelectorAll('input[name="selected_notifications[]"]').forEach(el => el.remove());
                    const checked = Array.from(document.querySelectorAll('.notification-checkbox'))
                        .filter(cb => cb.checked && cb.id.startsWith('notification_'))
                        .map(cb => cb.value);
                    if (checked.length === 0) {
                        e.preventDefault();
                        return false;
                    }
                    // Add hidden inputs for each selected notification
                    checked.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_notifications[]';
                        input.value = id;
                        deleteSelectedForm.appendChild(input);
                    });
                });
            }

            // Realtime updates for notifications page
            if (typeof Ably !== 'undefined') {
                const ablyKey = @json(config('app.ably_key'));
                const currentUserId = Number(@json(getActiveUser()->id));
                const csrfToken = @json(csrf_token());
                const notificationsList = document.getElementById('notifications-page-list');
                const notificationsPageUrl = @json(route('dashboard.notifications.index'));
                const readUrlBase = @json(route('dashboard.notifications.read', ['id' => '__ID__']));
                const destroyUrlBase = @json(route('dashboard.notifications.destroy', ['id' => '__ID__']));
                const justNowLabel = @json(__('main.just_now'));
                const newStatusLabel = @json(__('main.notification_new_status'));
                const openButtonHtml = @json(getActiveUser()->button_display_mode === 'text'
                        ? __('main.notification_open_action')
                        : (getActiveUser()->button_display_mode === 'icon'
                            ? '<i class="fas fa-external-link-alt text-white"></i>'
                            : '<i class="fas fa-external-link-alt text-white"></i> ' . __('main.notification_open_action')));
                const deleteButtonHtml = @json(getActiveUser()->button_display_mode === 'text'
                        ? __('main.delete')
                        : (getActiveUser()->button_display_mode === 'icon'
                            ? '<i class="fas fa-trash text-white"></i>'
                            : '<i class="fas fa-trash text-white"></i> ' . __('main.delete')));

                const escapeHtml = (value) => String(value ?? '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');

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
                    if (!ablyKey || !notificationsList) {
                        return;
                    }

                    if (payload.target_user_id && Number(payload.target_user_id) !== currentUserId) {
                        return;
                    }

                    const rawKey = String(payload.notification_id ?? payload.id ?? `${payload.type || 'notification'}-${payload.subject || ''}-${payload.created_at || Date.now()}`);
                    const key = rawKey.replace(/[^a-zA-Z0-9_-]/g, '_');

                    if (notificationsList.querySelector(`[data-live-notification-key="${key}"]`)) {
                        return;
                    }

                    document.getElementById('notifications-empty-state')?.remove();

                    const notificationId = payload.notification_id ?? payload.id ?? null;
                    const item = document.createElement('div');
                    item.className = 'flex items-start gap-4 p-4 border-b border-gray-300 bg-blue-50 hover:bg-gray-50 transition';
                    item.dataset.liveNotificationKey = key;

                    const safeSubject = escapeHtml(payload.subject || '');
                    const safeBody = escapeHtml(payload.body || '');
                    const safeDate = escapeHtml(payload.created_at_human || justNowLabel);
                    const safeUrl = escapeHtml(payload.url || '#');

                    const checkboxHtml = notificationId ? `
                        <div class="custom-input">
                            <input type="checkbox" name="selected_notifications[]" class="notification-checkbox"
                                id="notification_${notificationId}" value="${notificationId}" data-kt-datatable-row-check="true">
                            <label for="notification_${notificationId}"></label>
                        </div>
                    ` : '';

                    const openActionHtml = notificationId ? `
                        <form method="POST" action="${readUrlBase.replace('__ID__', notificationId)}" class="inline-block">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline-primary text-xs" toggle-button>${openButtonHtml}</button>
                        </form>
                    ` : `
                        <form method="GET" action="${safeUrl}" class="inline-block">
                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline-primary text-xs" toggle-button>${openButtonHtml}</button>
                        </form>
                    `;

                    const deleteActionHtml = notificationId ? `
                        <form method="POST" action="${destroyUrlBase.replace('__ID__', notificationId)}" class="inline-block">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="kt-btn kt-btn-sm bg-danger text-xs" toggle-button onclick="return confirm('{{ __('main.are_you_sure') }}');">${deleteButtonHtml}</button>
                        </form>
                    ` : '';

                    item.innerHTML = `
                        <div class="mt-2">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="" value="">
                                ${checkboxHtml}
                            </div>
                        </div>
                        <div class="text-xl mt-1 shrink-0 w-8 text-center">
                            ${notificationIconHtml(payload.type)}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-600 text-sm">${safeSubject}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-600 mt-0.5">${safeBody}</p>
                            <p class="text-xs text-gray-600 mt-1">
                                ${safeDate}
                                &bull; <span class="text-blue-500 font-medium">${escapeHtml(newStatusLabel)}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            ${openActionHtml}
                            ${deleteActionHtml}
                        </div>
                    `;

                    notificationsList.prepend(item);

                    const checkbox = item.querySelector('.notification-checkbox');
                    if (checkbox) {
                        checkbox.addEventListener('change', updateDeleteButtons);
                    }

                    if (notificationsList.children.length > 20) {
                        notificationsList.lastElementChild?.remove();
                    }

                    updateDeleteButtons();
                };

                const syncNotificationsFromServer = async () => {
                    if (!notificationsPageUrl || document.hidden) {
                        return;
                    }

                    try {
                        const response = await fetch(notificationsPageUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            credentials: 'same-origin',
                        });

                        if (!response.ok) {
                            return;
                        }

                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const latestList = doc.getElementById('notifications-page-list');

                        if (!latestList || !notificationsList) {
                            return;
                        }

                        notificationsList.innerHTML = latestList.innerHTML;
                        bindNotificationCheckboxes();
                        updateDeleteButtons();
                    } catch (error) {
                        console.warn('Notifications sync failed:', error);
                    }
                };

                window.addEventListener('dashboard-notification-received', function() {
                    syncNotificationsFromServer();
                });

                document.addEventListener('visibilitychange', function() {
                    if (!document.hidden) {
                        syncNotificationsFromServer();
                    }
                });

                if (ablyKey && notificationsList) {
                    const realtime = new Ably.Realtime({
                        key: ablyKey,
                        logLevel: 1,
                    });

                    const channel = realtime.channels.get('dashboard-notifications');
                    channel.subscribe('ticket-notification', (message) => {
                        const payload = message?.data || {};
                        prependNotification(payload);
                        window.dispatchEvent(new CustomEvent('dashboard-notification-received', {
                            detail: payload,
                        }));
                    });

                    setInterval(() => {
                        syncNotificationsFromServer();
                    }, 15000);

                    window.addEventListener('beforeunload', function() {
                        realtime?.close();
                    });
                }
            }
        });
    </script>
@endpush
