<style>
    .custom-dropdown {
        width: 300px;
        border-radius: calc(var(--radius) - 2px);
        border-style: 1px var(--tw-border-style) var(--border);
        color: var(--primary);
        background-color: var(--light-color);
        --tw-shadow: 0 4px 6px -1px var(--tw-shadow-color, rgb(0 0 0 / 0.1)), 0 2px 4px -2px var(--tw-shadow-color, rgb(0 0 0 / 0.1));
        box-shadow: var(--tw-inset-shadow), var(--tw-inset-ring-shadow), var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);
        position: absolute;
        top: 70px;
        right: 0;
        left: auto;
        z-index: 50;
    }

    #accountSwitcherList {
        &::-webkit-scrollbar {
            width: 4px;
        }

        &::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: var(--color-gray-400);
        }
    }

    html[lang=ar] .custom-dropdown {
        left: 0;
        right: auto;
    }
</style>

<!-- Account Switcher Dropdown -->
<div class="relative" id="accountSwitcher">
    <button class="action-button kt-btn" id="accountSwitcherBtn">
        <i class="ki-filled ki-arrow-right-left text-lg"></i>
    </button>

    <div class="custom-dropdown w-full max-w-56 text-sm hidden">
        <div class="flex flex-col divide-y divide-border max-h-64 overflow-y-auto" id="accountSwitcherList">
            @foreach ($availableUsers as $user)
                <button type="button" onclick="switchAccount({{ $user->id }})"
                    class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 cursor-pointer transition-colors text-start {{ getActiveUserId() === $user->id ? 'bg-primary/10 border-l-2 border-primary' : '' }}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                        @if ($user->photo && checkExistFile($user->photo))
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <span class="text-xs font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        {{-- <p class="text-sm font-medium text-gray-600">{{ $user->name }}</p> --}}
                        {{-- <p class="text-xs text-gray-600 truncate">{{ $user->email }}</p> --}}
                        {{-- <div class="flex items-center gap-1 mt-1"> --}}
                        <div class="flex items-center gap-1">
                            @foreach ($user->getRoleNames() as $role)
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">
                                    {{ __('main.' . $role) }} <br /> {{ $user->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @if (getActiveUserId() === $user->id)
                        <i class="ki-filled ki-check text-lg ms-auto" style="color: var(--color-green-600) !important"></i>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="px-4 py-2 border-t border-border">
            <p class="text-xs text-gray-600 text-center">💡 {{ __('messages.dev_account_switcher') }}</p>
        </div>
    </div>
</div>

<script>
    function switchAccount(userId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('dashboard.account.switch') }}';

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.content;
            form.appendChild(csrfInput);
        }

        const userIdInput = document.createElement('input');
        userIdInput.type = 'hidden';
        userIdInput.name = 'user_id';
        userIdInput.value = userId;
        form.appendChild(userIdInput);

        document.body.appendChild(form);
        form.submit();
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('#accountSwitcher .custom-dropdown');
        const button = document.getElementById('accountSwitcherBtn');

        if (button.contains(event.target)) {
            dropdown.classList.toggle('hidden');
        } else if (!dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
