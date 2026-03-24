@extends('layouts.master')

@if ($article instanceof \App\Models\Article)
    @php
        $articleTitle = $article->translations[app()->getLocale()]['title'] ?? ($article->translations['en']['title'] ?? $article->slug);
        $articleDescription = $article->translations[app()->getLocale()]['description'] ?? ($article->translations['en']['description'] ?? '');
    @endphp

    @section('title', $articleTitle . ' | ' . __('main.brand_name'))
    @section('meta_title', $articleTitle . ' | ' . __('main.brand_name'))
    @section('meta_description', \Illuminate\Support\Str::limit(strip_tags($articleDescription), 160))
@else
    @section('title', __('main.article_not_found') . ' | ' . __('main.brand_name'))
    @section('meta_title', __('main.article_not_found') . ' | ' . __('main.brand_name'))
    @section('meta_description', __('main.please_try_again'))
@endif

@section('content')
    <div class="blog-show">
        <section class="blog-content">
            <div class="text">
                @if ($article instanceof \App\Models\Article)
                    <div class="heading">
                        {{ $article->translations[app()->getLocale()]['title'] ?? ($article->translations['en']['title'] ?? $article->slug) }}
                    </div>
                    <div class="created_at">
                        <span>{{ $article->created_at?->format('Y-m-d') }}</span>•<span>{{ __('main.brand_name') }}</span>
                    </div>
                    @if ($article->image)
                        <div class="image">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->translations[app()->getLocale()]['title'] ?? $article->slug }}">
                        </div>
                    @endif
                    <div class="description">
                        {{ $article->translations[app()->getLocale()]['description'] ?? ($article->translations['en']['description'] ?? '') }}
                    </div>
                @else
                    <div class="heading">
                        {{ __('main.article_not_found') }}
                    </div>
                    <div class="description">
                        {{ __('main.please_try_again') }}
                    </div>
                @endif
            </div>

            <div class="share-your-articles mb-4">
                <div class="title">{{ __('main.blog_share_article') }}</div>
                <div class="links grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                        class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#3b5998">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        {{ __('main.social_facebook') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&amp;text={{ urlencode($article->title ?? '') }}"
                        class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#000000">
                            <i class="fab fa-x-twitter"></i>
                        </div>
                        {{ __('main.social_twitter') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                        class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#0077B5">
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                        {{ __('main.social_linkedin') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode(($article->title ?? '') . ' ' . url()->current()) }}"
                        class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#25D366">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        {{ __('main.social_whatsapp') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&amp;text={{ urlencode($article->title ?? '') }}"
                        class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#0088cc">
                            <i class="fab fa-telegram-plane"></i>
                        </div>
                        {{ __('main.social_telegram') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            <div class="main-articles-section border-custom" style="padding: var(--inline-padding);">
                <div class="title">{{ __('main.blog_similar_articles') }}</div>
                <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                    @if ($similarArticles && count($similarArticles) > 0)
                        @foreach ($similarArticles as $similar)
                            @if ($similar instanceof \App\Models\Article)
                                <div class="article">
                                    <div class="image">
                                        @if ($similar->image)
                                            <img src="{{ asset('storage/' . $similar->image) }}" alt="{{ $similar->translations[app()->getLocale()]['title'] ?? $similar->slug }}">
                                        @else
                                            <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="visitor">
                                        <i class="fas fa-eye"></i>
                                        {{ $similar->visitors ?? ($similar->view_count ?? rand(254, 584)) }}
                                    </div>
                                    <div class="content">
                                        <div class="body">
                                            <a href="{{ route('blog.show', ['id' => $similar->id, 'slug' => $similar->slug]) }}"
                                                class="title font-semibold">{{ limitedText($similar->translations[app()->getLocale()]['title'] ?? $similar->slug, 30) }}</a>
                                            <div class="description">{{ limitedText($similar->translations[app()->getLocale()]['description'] ?? '', 60) }}</div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn-link font-semibold details">
                                                <a href="{{ route('blog.show', ['id' => $similar->id, 'slug' => $similar->slug]) }}">
                                                    {{ __('main.details_button') }}
                                                </a>
                                            </button>
                                            <button class="btn-link font-semibold whatsapp">
                                                <a href="#contact">
                                                    {{ __('main.whatsapp_button') }}
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @elseif (config('articles') && count(config('articles')) > 0)
                        @foreach (config('articles') as $key => $article)
                            @if ($key < 3)
                                <div class="article">
                                    <div class="image">
                                        @if (rand(0, 1) == 1)
                                            <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="visitor">
                                        <i class="fas fa-eye"></i>
                                        {{ rand(254, 584) }}
                                    </div>
                                    <div class="content">
                                        <div class="body">
                                            <a href="{{ route('blog.show', ['id' => $key + 1]) }}" class="title font-semibold">{{ limitedText($article['title'], 30) }}</a>
                                            <div class="description">{{ limitedText($article['description'], 60) }}</div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn-link font-semibold details">
                                                <a href="{{ route('blog.show', ['id' => $key + 1]) }}">
                                                    {{ __('main.details_button') }}
                                                </a>
                                            </button>
                                            <button class="btn-link font-semibold whatsapp">
                                                <a href="#contact">
                                                    {{ __('main.whatsapp_button') }}
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <aside class="side">
            <div class="reviews-image">
                <div class="reviews-image">
                    <img src="{{ asset('assets/images/website/dark-reviews-bg.jpg') }}" alt="{{ __('main.first_marketing_logo') }}">
                </div>
            </div>
            @if ($categories && count($categories) > 0)
                <div class="categories">
                    <div class="title font-semibold">{{ __('main.blog_categories') }}</div>

                    <ul>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', ['id' => $category->id]) }}">
                                    <span>{{ $category->name ?? $category->slug }}</span>
                                    <strong>{{ $category->articles_count ?? rand(6, 64) }}</strong>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="categories">
                <div class="title font-semibold">{{ __('main.blog_contact_info') }}</div>

                <ul>
                    <li>
                        <a href="https://wa.me/{{ config('app.whatsapp') }}">
                            <span>
                                <i class="icon fab fa-whatsapp"></i>
                                {{ __('main.blog_whatsapp') }}
                            </span>
                            <strong>{{ config('app.whatsapp') }}</strong>
                        </a>
                    </li>
                    <li>
                        <a href="tel:{{ config('app.phone') }}">
                            <span>
                                <i class="icon fas fa-phone"></i>
                                {{ __('main.blog_call') }}
                            </span>
                            <strong>{{ config('app.phone') }}</strong>
                        </a>
                    </li>
                </ul>

                @if ($mostReadArticles && count($mostReadArticles) > 0)
                    <div class="articles">
                        <div class="title font-semibold">{{ __('main.blog_latest_articles') }}</div>
                        <div class="latest-articles">
                            @foreach ($mostReadArticles as $article)
                                <a href="{{ route('blog.show', ['id' => $article->id, 'slug' => $article->slug]) }}" class="article flex items-center gap-2">
                                    <div class="image">
                                        <img src="{{ asset('assets/images/website/projects/' . ($article->id ?? 1) . '.png') }}" alt="{{ $article->title }}">
                                    </div>
                                    <div class="info">
                                        <p class="font-semibold">{{ $article->title }}</p>
                                        <small>{{ $article->created_at ?? __('main.date_unavailable') }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @if ($mostReadArticles && count($mostReadArticles) > 0)
                <div class="categories">
                    <div class="title font-semibold">{{ __('main.blog_most_read') }}</div>
                    <div class="articles">
                        <div class="latest-articles">
                            @foreach ($mostReadArticles as $article)
                                <a href="{{ route('blog.show', ['id' => $article->id, 'slug' => $article->slug]) }}" class="article flex items-center gap-2">
                                    <div class="image">
                                        <img src="{{ asset('assets/images/website/projects/' . ($article->id ?? 1) . '.png') }}" alt="{{ $article->title }}">
                                    </div>
                                    <div class="info">
                                        <p class="font-semibold">{{ $article->title }}</p>
                                        <small>{{ $article->created_at ?? __('main.date_unavailable') }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </aside>
    </div>
@endsection
