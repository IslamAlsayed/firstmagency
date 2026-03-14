@if (isset($record) && $record && getActiveUser()->can("$models-update"))
    <div class="relative group inline-block">
        <button class="px-3 py-1 cursor-pointer text-nowrap bg-gray-200 hover:bg-gray-300 rounded-md text-xs font-semibold transition"
            title="Change {{ $fieldName ?? 'Status' }}">
            <i class="fas fa-exchange-alt"></i>
            <span class="hidden sm:inline">{{ __('main.change') }}</span>
        </button>

        <!-- Dropdown Menu -->
        <div
            class="absolute right-0 mt-1 w-40 bg-white border border-gray-300 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
            <div class="py-1">
                @foreach ($availableOptions as $key => $value)
                    @php
                        // Determine if this is a key-value array (for fields like department_id)
                        $optionKey = is_numeric($key) ? $key : $value;
                        $optionLabel = is_numeric($key) ? $value : $key;

                        // Check if current option is selected
                        $fieldNameToCheck = $fieldName ?? 'status';
                        $isSelected = ($record->{$fieldNameToCheck} ?? null) == $optionKey || ($record->{$fieldNameToCheck} ?? null) === $value;
                    @endphp
                    <form method="POST" action="{{ route('dashboard.models.changeStatus', [$models, $modelClass, $record->id, $optionKey]) }}"
                        style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="field" value="{{ $fieldName ?? 'status' }}">
                        <button type="submit"
                            class="w-full cursor-pointer text-left px-4 py-2 hover:bg-gray-100 text-sm flex items-center gap-2
                            @if ($isSelected) bg-blue-100 text-blue-900 @endif">

                            @if ($optionLabel === 'draft')
                                <i class="fas fa-file-alt text-yellow-600"></i>
                                <span>{{ __('main.draft') }}</span>
                            @elseif ($optionLabel === 'published')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.published') }}</span>
                            @elseif ($optionLabel === 'archived')
                                <i class="fas fa-archive text-red-600"></i>
                                <span>{{ __('main.archived') }}</span>
                            @elseif ($optionLabel === 'open')
                                <i class="fas fa-folder-open text-yellow-600"></i>
                                <span>{{ __('main.open') }}</span>
                            @elseif ($optionLabel === 'in_progress')
                                <i class="fas fa-spinner text-blue-600"></i>
                                <span>{{ __('main.in_progress') }}</span>
                            @elseif ($optionLabel === 'processed')
                                <i class="fas fa-chart-diagram text-violet-600"></i>
                                <span>{{ __('main.processed') }}</span>
                            @elseif ($optionLabel === 'resolved')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.resolved') }}</span>
                            @elseif ($optionLabel === 'replied')
                                <i class="fas fa-check text-green-600"></i>
                                <span>{{ __('main.replied') }}</span>
                            @elseif ($optionLabel === 'closed')
                                <i class="fas fa-times-circle text-red-600"></i>
                                <span>{{ __('main.closed') }}</span>
                            @elseif ($optionLabel === 'pending')
                                <i class="fas fa-clock text-yellow-600"></i>
                                <span>{{ __('main.pending') }}</span>
                            @elseif ($optionLabel === 'approved')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.approved') }}</span>
                            @elseif($optionLabel === 'rejected')
                                <i class="fas fa-times-circle text-red-600"></i>
                                <span>{{ __('main.rejected') }}</span>
                            @elseif ($optionLabel === 'active' || $optionLabel === 'is_active')
                                <i class="fas fa-check-circle text-green-600"></i>
                                <span>{{ __('main.active') }}</span>
                            @elseif ($optionLabel === 'is_featured')
                                <i class="fas fa-star text-pink-600"></i>
                                <span>{{ __('main.featured') }}</span>
                            @elseif ($optionLabel === 'sales')
                                <i class="fas fa-shopping-cart text-orange-600"></i>
                                <span>{{ __('main.sales') }}</span>
                            @elseif ($optionLabel === 'support')
                                <i class="fas fa-headset text-green-600"></i>
                                <span>{{ __('main.support') }}</span>
                            @elseif ($optionLabel === 'general')
                                <i class="fas fa-envelope text-gray-600"></i>
                                <span>{{ __('main.general') }}</span>
                            @else
                                {{-- For numeric keys (like department IDs), display the value as-is --}}
                                @if (is_numeric($key))
                                    <i class="fas fa-folder text-blue-600"></i>
                                    <span>{{ $value }}</span>
                                @else
                                    <i class="fas fa-times-circle text-red-600"></i>
                                    <span>{{ __('main.' . $optionLabel) }}</span>
                                @endif
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endif
