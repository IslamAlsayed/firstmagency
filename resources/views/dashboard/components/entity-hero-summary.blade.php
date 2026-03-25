<div class="entity-hero-side">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-sm font-bold text-white/85">{{ __('main.last_update') }}</p>
            <p class="text-xs text-white/70">{{ now()->format('d M Y - H:i A') }}</p>
        </div>
        <div class="text-4xl text-white/20">
            <i class="{{ $icon }}"></i>
        </div>
    </div>

    <div class="entity-hero-side-grid">
        @foreach ($items as $item)
            <div class="entity-hero-side-item">
                <strong @if(!empty($item['id'])) id="{{ $item['id'] }}" @endif @if(!empty($item['class'])) class="{{ $item['class'] }}" @endif>
                    {{ $item['value'] }}
                </strong>
                <span class="text-sm text-white/80">{{ $item['label'] }}</span>
            </div>
        @endforeach
    </div>
</div>