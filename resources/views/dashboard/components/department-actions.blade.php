@if (isset($record) && $record && getActiveUser()->can('departments-update'))
    <div class="relative group inline-block">
        <button class="px-3 py-1 cursor-pointer text-nowrap bg-gray-200 hover:bg-gray-300 rounded-md text-xs font-semibold transition" title="Change {{ __('main.department') }}">
            <i class="fas fa-exchange-alt"></i>
            {{-- <span class="hidden sm:inline">{{ __('main.change') }}</span> --}}
        </button>

        <!-- Dropdown Menu -->
        <div class="absolute right-0 mt-1 w-48 bg-white border border-gray-300 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
            <div class="py-1 max-h-64 overflow-y-auto">
                @forelse ($availableOptions as $departmentId => $departmentName)
                    @php
                        $isSelected = ($record->department_id ?? null) == $departmentId;
                    @endphp
                    <form method="POST" action="{{ route('dashboard.departments.change-ticket-department', [$departmentId, $record->id]) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="department_id" value="{{ $departmentId }}">
                        <button type="submit"
                            class="w-full text-start cursor-pointer px-4 py-2 hover:bg-gray-100 text-sm flex items-center gap-2 transition
                            @if ($isSelected) bg-blue-100 text-blue-900 @endif">

                            <i class="fas fa-building text-primary"></i>
                            <span class="flex-1">{{ __('main.' . str_replace('-', '_', str_replace(' ', '_', $departmentName))) }}</span>

                            @if ($isSelected)
                                <i class="fas fa-check text-green-600 ms-2"></i>
                            @endif
                        </button>
                    </form>
                @empty
                    <div class="px-4 py-2 text-sm text-gray-500 text-center">
                        {{ __('main.no_departments_available') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endif
