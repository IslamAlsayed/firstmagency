<!-- Locale Switcher -->
<div class="locale-switcher flex items-center gap-2">
    @php
        $currentLocale = app()->getLocale();
        $availableLocales = array_keys(config('languages'));
    @endphp

    @foreach ($availableLocales as $locale)
        @if ($locale === $currentLocale)
            <span class="px-3 py-1 bg-primary text-white rounded-md font-semibold">
                {{ config("languages.{$locale}") }}
            </span>
        @else
            <a href="{{ route('locale.change', $locale) }}" class="px-3 py-1 bg-gray-200 text-gray-800 rounded-md font-semibold hover:bg-gray-300 transition">
                {{ config("languages.{$locale}") }}
            </a>
        @endif
    @endforeach
</div>
