@if (isset($record) && $record && getActiveUser()->can('reviews-update'))
    <div class="relative group inline-block">
        <button class="px-3 py-1 cursor-pointer text-nowrap bg-gray-200 hover:bg-gray-300 rounded-md text-xs font-semibold transition" title="Change Status">
            <i class="fas fa-exchange-alt"></i>
            <span class="hidden sm:inline">{{ __('main.change') }}</span>
        </button>

        <!-- Dropdown Menu -->
        <div
            class="absolute right-0 mt-1 w-40 bg-white border border-gray-300 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
            <div class="py-1">
                @foreach (['pending', 'approved', 'rejected'] as $status)
                    <form method="POST" action="{{ route('dashboard.reviews.changeStatus', [$record->id, $status]) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full cursor-pointer text-left px-4 py-2 hover:bg-gray-100 text-sm flex items-center gap-2
                            @if ($record->status === $status) bg-blue-100 text-blue-900 @endif">

                            @if ($status === 'pending')
                                <i class="fas fa-clock text-yellow-500"></i>
                                <span>{{ __('main.pending') }}</span>
                                {{-- <span>{{ '⏳ ' . __('main.pending') }}</span> --}}
                            @elseif ($status === 'approved')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.approved') }}</span>
                                {{-- <span>{{ '✅ ' . __('main.approved') }}</span> --}}
                            @else
                                <i class="fas fa-times-circle text-red-600"></i>
                                <span>{{ __('main.rejected') }}</span>
                                {{-- <span>{{ '❌ ' . __('main.rejected') }}</span> --}}
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endif
