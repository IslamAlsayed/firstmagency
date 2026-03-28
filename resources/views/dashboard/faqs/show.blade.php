@extends('dashboard.layout.master')

@section('title', $faq->question)
@section('page-title', '❓ ' . limitedText($faq->question, 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $faq->question }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $faq->creator?->name ?? 'N/A' }} • {{ $faq->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $faq))
                    <a href="{{ route('dashboard.faqs.edit', $faq->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.faqs.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.faqs')]) }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- FAQ Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.faq_information') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.category') }}</p>
                            <p class="font-semibold text-gray-800">{{ $faq->CATEGORIES[$faq->category] ?? $faq->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $faq->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($faq->creator)
                                    <a href="{{ route('dashboard.users.show', $faq->creator->id) }}" class="text-primary hover:underline">
                                        {{ $faq->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $faq->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.updated_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($faq->updater)
                                    <a href="{{ route('dashboard.users.show', $faq->updater->id) }}" class="text-primary hover:underline">
                                        {{ $faq->updater->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.updated_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $faq->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $faq->id,
                                'field' => 'is_active',
                                'value' => (bool) $faq->is_active,
                                'modelClass' => 'faq',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.faq_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Language Tabs -->
                    <div class="flex gap-4 mb-6">
                        @foreach (['en' => 'English', 'ar' => 'العربية'] as $lang => $label)
                            <button type="button"
                                class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2 transition"
                                data-lang="{{ $lang }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <!-- English Content -->
                    <div class="language-content" data-lang="en">
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.question') }}</p>
                            <div class="text-gray-700 font-semibold bg-white p-3 rounded border border-gray-200">
                                {{ $faq->question ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.answer') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200 prose prose-sm max-w-none">
                                {!! $faq->answer ?? '-' !!}
                            </div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.question') }}</p>
                            <div class="text-gray-700 font-semibold bg-white p-3 rounded border border-gray-200 text-right" dir="rtl">
                                {{ $faq->question_ar ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">{{ __('main.answer') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200 prose prose-sm max-w-none text-right" dir="rtl">
                                {!! $faq->answer_ar ?? '-' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $faq)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.faqs',
                        'id' => $faq->id,
                    ])
                @endcan
                @can('delete', $faq)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.faqs',
                        'modelClass' => 'faq',
                        'id' => $faq->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.faqs.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.faqs')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
