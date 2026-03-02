@extends('dashboard.layout.master')

@section('title', $article->title)
@section('page-title', '📄 ' . limitedText($article->title, 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $article->author?->name ?? 'N/A' }} • {{ $article->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $article))
                    <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.articles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.articles')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.article_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="flex items-center gap-4 mb-6">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($article->status === 'published') bg-green-100 text-green-800
                            @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ __('main.status_' . $article->status) }}
                        </span>
                        @if ($article->featured)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-star"></i> {{ __('main.featured') }}
                            </span>
                        @endif
                        @if (!$article->is_active)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">{{ __('main.inactive') }}</span>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="col-span-full border-custom rounded-lg p-4 mb-4">
                        <label class="kt-label mb-2 text-lg">{{ __('main.description') }}</label>
                        <p class="text-xs text-secondary-foreground text-gray-100">
                            {!! $article->translations[app()->getLocale()]['description'] ?? '' !!}
                        </p>
                    </div>

                    {{-- Content --}}
                    <div class="col-span-full border-custom rounded-lg p-4 mb-4">
                        <label class="kt-label mb-2 text-lg">{{ __('main.content') }}</label>
                        <p class="text-xs text-secondary-foreground text-gray-100">
                            {!! $article->translations[app()->getLocale()]['content'] ?? '' !!}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if ($article->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $article->category->name }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="kt-label mb-1">{{ __('main.statistics') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <i class="fas fa-eye text-blue-500"></i> {{ $article->view_count ?? 0 }} {{ __('main.views') }}
                            </p>
                        </div>

                        @if ($article->keywords)
                            <div class="col-span-1 sm:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.keywords') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $article->keywords) as $keyword)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($article->meta_description)
                            <div class="col-span-1 sm:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.meta_description') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $article->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($article->image))
                @include('dashboard.components.display-photo', ['record' => $article, 'column' => 'image', 'alt' => $article->title . ' Image'])
            @endif

            @if (!empty($article->thumbnail))
                @include('dashboard.components.display-photo', [
                    'record' => $article,
                    'column' => 'thumbnail',
                    'alt' => $article->title . ' Thumbnail',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $article])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $article)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.articles',
                        'id' => $article->id,
                    ])
                @endcan
                @can('delete', $article)
                    @include('dashboard.components.delete-form', [
                        'model' => 'dashboard.articles',
                        'id' => $article->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.articles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.articles')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
