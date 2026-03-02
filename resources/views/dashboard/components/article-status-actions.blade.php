@if (isset($record) && $record && getActiveUser()->can('articles-update'))
    <div class="relative group inline-block">
        <button class="px-3 py-1 cursor-pointer text-nowrap bg-gray-200 hover:bg-gray-300 rounded-md text-xs font-semibold transition" title="Change Status">
            <i class="fas fa-exchange-alt"></i>
            <span class="hidden sm:inline">{{ __('main.change') }}</span>
        </button>

        <!-- Dropdown Menu -->
        <div
            class="absolute right-0 mt-1 w-40 bg-white border border-gray-300 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
            <div class="py-1">
                @foreach (['draft', 'archived', 'published'] as $status)
                    <form method="POST" action="{{ route('dashboard.articles.changeStatus', [$record->id, $status]) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full cursor-pointer text-left px-4 py-2 hover:bg-gray-100 text-sm flex items-center gap-2
                            @if ($record->status === $status) bg-blue-100 text-blue-900 @endif">

                            @if ($status === 'draft')
                                <i class="fas fa-file-alt text-yellow-600"></i>
                                <span>{{ __('main.draft') }}</span>
                            @elseif ($status === 'published')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.published') }}</span>
                            @else
                                <i class="fas fa-archive text-red-600"></i>
                                <span>{{ __('main.archived') }}</span>
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endif
