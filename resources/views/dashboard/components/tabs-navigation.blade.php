<div class="flex gap-4">
    @foreach (array_keys(config('languages')) as $lang)
        <button type="button"
            class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2"
            data-lang="{{ $lang }}">
            {{ config("languages.$lang.flag") }} {{ __('main.' . $lang . '_content') }}
        </button>
    @endforeach
</div>
