@extends('layouts.master')

@section('content')
    <div class="blog-show">
        <div class="blog-content">
            <div class="text">
                <div class="heading">
                    {{ __('main.portfolio_description_sample') }}
                </div>
                <div class="created_at">
                    <span>{{ __('main.portfolio_date_sample') }}</span>•<span>{{ __('main.brand_name') }}</span>
                </div>
                <div class="image">
                    <img src="{{ asset('assets/images/projects/1.png') }}" alt="Blog Image">
                </div>
                <div class="description">
                    {{ __('articles.blog_intro') }}
                </div>
                <div class="heading">
                    {{ __('articles.blog_strategy_section') }}
                </div>
                <div class="description">
                    {{ __('articles.blog_strategy_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_target_section') }}
                </div>
                <div class="description">
                    {{ __('articles.blog_target_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_content_section') }}
                </div>
                <div class="description">
                    {{ __('articles.blog_content_text') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_analytics_section') }}
                </div>
                <div class="description">
                    {{ __('articles.blog_analytics_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_performance_section') }}
                </div>

                <div class="description">
                    {{ __('articles.blog_performance_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_monitoring_section') }}
                </div>

                <div class="description">
                    {{ __('articles.blog_monitoring_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_engagement_section') }}
                </div>

                <div class="description">
                    {{ __('articles.blog_engagement_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_comments_section') }}
                </div>

                <div class="description">
                    {{ __('articles.blog_comments_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_increase_engagement_section') }}
                </div>

                <div class="description">
                    {{ __('articles.blog_increase_engagement_content') }}
                </div>

                <div class="heading">
                    {{ __('articles.blog_success_strategies_section') }}
                </div>
                <div class="description">
                    {{ __('articles.blog_success_strategies_content') }}
                </div>
            </div>

            <div class="share-your-articles mb-4">
                <div class="title">{{ __('main.blog_share_article') }}</div>

                <div class="links grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                    <a href="#" class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#3b5998">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        {{ __('main.social_facebook') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="#" class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#000000">
                            <i class="fab fa-x-twitter"></i>
                        </div>
                        {{ __('main.social_twitter') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="#" class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#0077B5">
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                        {{ __('main.social_linkedin') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="#" class="link flex items-center justify-between gap-2">
                        <div class="icon" data-color="#25D366">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        {{ __('main.social_whatsapp') }}
                        <i class="arrow fas fa-square-arrow-up-right"></i>
                    </a>
                    <a href="#" class="link flex items-center justify-between gap-2">
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
                    @foreach (config('articles') as $key => $article)
                        @if ($key < 3)
                            <div class="article">
                                <div class="image">
                                    @if (rand(0, 1) == 1)
                                        <img src="{{ asset('assets/images/projects/' . rand(1, 12) . '.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="visitor">
                                    <i class="fas fa-eye"></i>
                                    {{ rand(254, 584) }}
                                </div>
                                <div class="content">
                                    <div class="body">
                                        <a href="#" class="title font-semibold">{{ limitedText($article['title'], 30) }}</a>
                                        <div class="description">{{ limitedText($article['description'], 60) }}</div>
                                    </div>
                                    <div class="actions">
                                        <button class="btn-link font-semibold details">
                                            <a href="{{ route('blog.show') }}">
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
                </div>
            </div>
        </div>

        <div class="side">
            <div class="reviews-image">
                <div class="reviews-image">
                    <img src="{{ asset('assets/images/dark-reviews-bg.jpg') }}" alt="First Marketing Logo">
                </div>
            </div>

            <div class="categories">
                <div class="title font-semibold">{{ __('main.blog_categories') }}</div>

                <ul>
                    <li><a href="#"><span>{{ __('main.blog_social_media_admin') }}</span> <strong>{{ rand(6, 64) }}</strong></a></li>
                    <li><a href="#"><span>{{ __('main.blog_website_design') }}</span> <strong>{{ rand(6, 64) }}</strong></a></li>
                    <li><a href="#"><span>{{ __('main.blog_digital_marketing') }}</span> <strong>{{ rand(6, 64) }}</strong></a></li>
                    <li><a href="#"><span>{{ __('main.blog_seo') }}</span> <strong>{{ rand(6, 64) }}</strong></a></li>
                </ul>
            </div>

            <div class="categories">
                <div class="title font-semibold">{{ __('main.blog_contact_info') }}</div>

                <ul>
                    <li><a href="#"><span><i class="icon fab fa-whatsapp"></i> {{ __('main.blog_whatsapp') }}</span> <strong>01212601601</strong></a></li>
                    <li><a href="#"><span><i class="icon fas fa-phone"></i> {{ __('main.blog_call') }}</span> <strong>01212601601</strong></a></li>
                </ul>

                <div class="articles">
                    <div class="title font-semibold">{{ __('main.blog_latest_articles') }}</div>

                    <div class="latest-articles">
                        @foreach (config('articles') as $key => $article)
                            <a href="#" class="article flex items-center gap-2">
                                <div class="image">
                                    <img src="{{ asset('assets/images/projects/' . rand(1, 12) . '.png') }}" alt="{{ $article['title'] }}">
                                </div>
                                <div class="info">
                                    <p class="font-semibold">{{ $article['title'] }}</p>
                                    <small>{{ $article['created_at'] ?? 'تاريخ غير متوفر' }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="categories">
                <div class="title font-semibold">{{ __('main.blog_most_read') }}</div>

                <div class="articles">
                    <div class="latest-articles">
                        @foreach (config('articles') as $key => $article)
                            @if ($key < 10)
                                <a href="#" class="article flex items-center gap-2">
                                    <div class="image">
                                        <img src="{{ asset('assets/images/projects/' . rand(1, 12) . '.png') }}" alt="{{ $article['title'] }}">
                                    </div>
                                    <div class="info">
                                        <p class="font-semibold">{{ $article['title'] }}</p>
                                        <small>{{ $article['created_at'] ?? 'تاريخ غير متوفر' }}</small>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.icon').forEach(icon => {
            const color = icon.getAttribute('data-color');
            if (color) {
                icon.style.setProperty('--icon-color', color);
            }
        });
    </script>
@endpush
