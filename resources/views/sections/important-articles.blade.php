<div class="section important-articles text-center">
    <div class="title font-semibold">{{ __('main.important_articles_title') }} <span class="title-badge">{{ __('main.important_articles_subtitle') }}</span></div>
    <div class="description">{{ __('main.important_articles_description') }}</div>

    <div class="main-articles-section">
        <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach (config('articles') as $key => $article)
                @if ($key < 4)
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
                                        التفاصيل
                                    </a>
                                </button>
                                <button class="btn-link font-semibold whatsapp">
                                    <a href="#contact">
                                        واتساب
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
