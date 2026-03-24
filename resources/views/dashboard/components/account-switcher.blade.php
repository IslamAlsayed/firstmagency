<style>
    #accountSwitcherList {
        &::-webkit-scrollbar {
            width: 4px;
        }

        &::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: var(--color-gray-400);
        }
    }
</style>

<!-- Account Switcher Dropdown -->
<div class="relative" id="accountSwitcher">
    <div class="flex flex-col divide-y divide-border overflow-y-auto" id="accountSwitcherList" style="max-height: 350px">
        @foreach ($availableUsers as $user)
            <button type="button" onclick="switchAccount({{ $user->id }})"
                class="flex items-center gap-3 px-4 py-2 cursor-pointer transition-colors text-start {{ getActiveUserId() === $user->id ? 'bg-primary/10' : 'hover:bg-gray-100' }}">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                    @if ($user->photo && checkExistFile($user->photo))
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <span class="text-xs font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
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
