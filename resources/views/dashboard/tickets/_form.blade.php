<div class="row">
    <div class="col-md-12 mb-3">
        <label for="title" class="form-label">{{ __('main.title') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
            value="{{ old('title', $ticket->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="description" class="form-label">{{ __('main.description') }} <span class="text-danger">*</span></label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $ticket->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">{{ __('main.status') }} <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="open" {{ old('status', $ticket->status ?? 'open') === 'open' ? 'selected' : '' }}>
                {{ __('main.open') }}
            </option>
            <option value="in_progress" {{ old('status', $ticket->status ?? '') === 'in_progress' ? 'selected' : '' }}>
                {{ __('main.in_progress') }}
            </option>
            <option value="resolved" {{ old('status', $ticket->status ?? '') === 'resolved' ? 'selected' : '' }}>
                {{ __('main.resolved') }}
            </option>
            <option value="closed" {{ old('status', $ticket->status ?? '') === 'closed' ? 'selected' : '' }}>
                {{ __('main.closed') }}
            </option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="priority" class="form-label">{{ __('main.priority') }} <span class="text-danger">*</span></label>
        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
            <option value="low" {{ old('priority', $ticket->priority ?? 'medium') === 'low' ? 'selected' : '' }}>
                {{ __('main.low') }}
            </option>
            <option value="medium" {{ old('priority', $ticket->priority ?? 'medium') === 'medium' ? 'selected' : '' }}>
                {{ __('main.medium') }}
            </option>
            <option value="high" {{ old('priority', $ticket->priority ?? 'medium') === 'high' ? 'selected' : '' }}>
                {{ __('main.high') }}
            </option>
            <option value="urgent" {{ old('priority', $ticket->priority ?? 'medium') === 'urgent' ? 'selected' : '' }}>
                {{ __('main.urgent') }}
            </option>
        </select>
        @error('priority')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="category" class="form-label">{{ __('main.category') }}</label>
        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category"
            value="{{ old('category', $ticket->category ?? '') }}">
        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="assigned_to" class="form-label">{{ __('main.assigned_to') }}</label>
        <select class="form-select @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to">
            <option value="">{{ __('main.select_user') }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->role }})
                </option>
            @endforeach
        </select>
        @error('assigned_to')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
