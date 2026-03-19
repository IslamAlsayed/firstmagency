@extends('dashboard.layout.master')

@section('title', __('main.notifications'))
@section('page-title', '🔔 ' . __('main.notifications'))

@section('content')
    <div class="kt-card">
        <div class="kt-card-header flex items-center justify-between gap-4 flex-wrap">
            <h3 class="kt-card-title">{{ __('main.notifications') }}</h3>
            @if (auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('dashboard.notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="kt-btn kt-btn-outline-primary text-sm">
                        <i class="fas fa-check-double me-1"></i>
                        {{ __('main.mark_all_read') }}
                    </button>
                </form>
            @endif
        </div>

        <div class="kt-card-body p-0">
            @forelse($notifications as $notification)
                <div class="flex items-start gap-4 p-4 border-b border-gray-300 {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }} hover:bg-gray-50 transition">
                    {{-- Icon --}}
                    <div class="text-xl mt-1 shrink-0 w-8 text-center">
                        @if ($notification->data['type'] === 'new_ticket')
                            <i class="fas fa-ticket-alt text-blue-500"></i>
                        @elseif($notification->data['type'] === 'customer_reply')
                            <i class="fas fa-reply text-green-500"></i>
                        @else
                            <i class="fas fa-star text-yellow-500"></i>
                        @endif
                    </div>

                    {{-- Content --}}
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

                    {{-- Action --}}
                    <form method="POST" action="{{ route('dashboard.notifications.read', $notification->id) }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline-primary text-xs">
                            {{ __('main.notification_open_action') }} <i class="fas fa-external-link-alt ms-1"></i>
                        </button>
                    </form>
                </div>
            @empty
                <div class="p-12 text-center text-gray-600 dark:text-gray-600">
                    <i class="fas fa-bell-slash text-4xl mb-3 block"></i>
                    <p>{{ __('main.no_notifications') }}</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="kt-card-footer p-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
