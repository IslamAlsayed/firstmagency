@extends('dashboard.layout.master')

@section('title', __('main.articles'))
@section('page-title', '📝 ' . __('main.articles'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- {{ __('main.statistics') }} -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-gray-800">{{ count($articles) }}</div>
                    <small class="text-gray-500">{{ __('main.total_articles') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $articles->where('status', 'published')->count() }}</div>
                    <small class="text-gray-500">{{ __('main.published') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-yellow-600">{{ $articles->where('status', 'draft')->count() }}</div>
                    <small class="text-gray-500">{{ __('main.draft') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-red-600">{{ $articles->where('status', 'archived')->count() }}</div>
                    <small class="text-gray-500">{{ __('main.archived') }}</small>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-newspaper mr-2"></i> {{ __('main.article_list') }}</h5>

                        <a href="{{ route('dashboard.articles.create') }}" class="kt-btn kt-btn-outline-primary">
                            {{ __('main.create_article') }}
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <input type="text" id="searchArticles"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="{{ __('main.search_articles_placeholder') }}">
                    </div>

                    {{-- <div class="overflow-x-auto"> --}}
                    <div class="">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.views') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articles as $article)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td title="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}" class="px-6 py-4">
                                            <div class="relative w-fit">
                                                @if ($article->image && checkExistFile($article->image))
                                                    <img src="{{ asset('storage/' . $article->image) }}"
                                                        alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}" class="rounded-full size-9 shrink-0">
                                                @else
                                                    <img src="{{ asset('assets/images/avatar.png') }}"
                                                        alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}" class="rounded-full size-9 shrink-0">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <strong class="text-sm text-gray-800 block">
                                                {{ limitedText($article->translations[app()->getLocale()]['title'] ?? '', 50) }}
                                            </strong>
                                            <small class="text-gray-500">
                                                {!! limitedText($article->translations[app()->getLocale()]['description'] ?? '', 50) !!}
                                            </small>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if ($article->status === 'published') bg-green-100 text-green-800
                                                @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ __('main.status_' . $article->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $article->creator->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $article->created_at?->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <i class="fas fa-eye text-blue-500"></i> {{ $article->view_count ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2 flex items-center gap-2">
                                            @include('dashboard.components.article-status-actions', [
                                                'record' => $article,
                                            ])
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $article,
                                                'models' => 'articles',
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                            {{ __('main.no_articles_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($articles->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
