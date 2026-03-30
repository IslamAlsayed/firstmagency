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
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <form method="POST" action="{{ route('dashboard.notifications.readAll') }}">
                            @csrf
                            <button type="submit" class="kt-btn kt-btn-outline-primary text-sm">
                                <i class="fas fa-check-double me-1"></i>
                                {{ __('main.mark_all_read') }}
                            </button>
                        </form>
                    @endif
                    @if (auth()->user()->notifications->count() > 0)
                        <!-- Delete All Form -->
                        <form id="delete_all_form" method="POST" action="{{ route('dashboard.notifications.destroyAll') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="delete_all" class="kt-btn bg-danger text-sm" onclick="return confirm('{{ __('main.are_you_sure') }}');">
                                <i class="fas fa-trash me-1"></i>
                                {{ __('main.delete_all') }}
                            </button>
                        </form>
                        <!-- Delete Selected Form -->
                        <form id="delete_selected_form" method="POST" action="{{ route('dashboard.notifications.destroyAll') }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="delete_selected" class="hidden kt-btn bg-danger text-sm" onclick="return confirm('{{ __('main.are_you_sure') }}');">
                                <i class="fas fa-trash me-1"></i>
                                {{ __('main.delete_selected') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="notifications-content">
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
                                <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline-primary text-xs">
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
                                <button type="submit" class="kt-btn kt-btn-sm bg-danger text-xs">
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
                    <div class="p-8 text-center text-gray-600 dark:text-gray-600">
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
            }
            document.querySelectorAll('.notification-checkbox').forEach(cb => {
                cb.addEventListener('change', updateDeleteButtons);
            });
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
        });
    </script>
@endpush
