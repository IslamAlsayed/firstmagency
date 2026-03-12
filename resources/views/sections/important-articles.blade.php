<section class="section important-articles text-center relative">
    {{-- <div class="title font-semibold">{{ __('main.important_articles_title') }} <span class="title-badge">{{ __('main.important_articles_subtitle') }}</span></div> --}}
    <div class="title font-semibold">{{ $title ?? __('main.important_articles_title') }} <span
            class="title-badge">{{ __('main.important_articles_subtitle') }}</span></div>
    <div class="description">{{ $desc ?? __('main.important_articles_description') }}</div>

    <div class="main-articles-section">
        <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @php
                $articlesList = isset($articles) && count($articles) > 0 ? $articles : config('articles') ?? [];
            @endphp
            @if ($articlesList && count($articlesList) > 0)
                @foreach ($articlesList as $key => $article)
                    @if ($article instanceof \App\Models\Article)
                        {{-- Display from Database --}}
                        <div class="article">
                            <div class="image">
                                @if (rand(0, 1) == 1)
                                    <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}"
                                        alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}">
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
                    @else
                        {{-- Display from Config (Fallback) --}}
                        <div class="article">
                            <div class="image">
                                @if (rand(0, 1) == 1)
                                    <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}" alt="{{ $article['title'] ?? '' }}">
                                @endif
                            </div>
                            <div class="visitor">
                                <i class="fas fa-eye"></i>
                                {{ rand(254, 584) }}
                            </div>
                            <div class="content">
                                <div class="body">
                                    <a href="{{ route('blog.show', ['id' => $key + 1]) }}"
                                        class="title font-semibold">{{ limitedText($article['title'] ?? '', 30) }}</a>
                                    <div class="description">{{ limitedText($article['description'] ?? '', 120) }}</div>
                                </div>
                                <div class="actions">
                                    <button class="btn-link font-semibold details">
                                        <a href="{{ route('blog.show', ['id' => $key + 1]) }}">
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
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-important-articles</div>
    @endif
</section>
