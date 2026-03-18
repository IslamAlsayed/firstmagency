<section class="section important-articles text-center relative">
    <div class="title font-semibold">{{ __('main.important_marketing_articles_title') }} <span class="title-badge">{{ __('main.important_marketing_articles_subtitle') }}</span></div>
    <div class="description">{{ __('main.important_marketing_articles_description') }}</div>

    <div class="main-articles-section">
        <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @php
                $articlesList = isset($articles) && count($articles) > 0 ? $articles : [];
            @endphp
            @if ($articlesList && count($articlesList) > 0)
                @foreach ($articlesList as $key => $article)
                    <div class="article">
                        <div class="image">
                            @if (rand(0, 1) == 1)
                                <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}" alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}">
                            @endif
                        </div>
                        <div class="visitor">
                            <i class="fas fa-eye"></i>
                            {{ $article->visitors }}
                        </div>
                        <div class="content">
                            <div class="body">
                                <a href="{{ route('blog.show', ['id' => $article->id]) }}"
                                    class="title font-semibold">{{ limitedText($article->translations[app()->getLocale()]['title'] ?? '', 30) }}</a>
                                <div class="description">{{ limitedText($article->translations[app()->getLocale()]['description'] ?? '', 120) }}</div>
                            </div>
                            <div class="actions">
                                <button class="btn-link font-semibold details">
                                    <a href="{{ route('blog.show', ['id' => $article->id]) }}">
                                        {{ __('main.details_button') }}
                                    </a>
                                </button>
                                <button class="btn-link font-semibold whatsapp">
                                    <a href="https://api.whatsapp.com/send?phone={{ config('app.whatsapp') }}" target="_blank">
                                        {{ __('main.whatsapp_button') }}
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-important-articles-marketing</div>
    @endif
</section>
