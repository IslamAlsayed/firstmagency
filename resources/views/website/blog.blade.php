@extends('layouts.master')

@section('content')
    <div class="articles-page relative">
        <section class="articles-section">
            <div class="heading-title">
                <div class="title font-semibold">مدونة <span class="title-badge">{{ __('main.brand_name') }}</span></div>
                <div class="description"></div>
            </div>

            <div class="main-articles-section">
                <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="articlesContainer">
                    @if ($articles && count($articles) > 0)
                        @php
                            $paginate = 24;
                        @endphp
                        @foreach ($articles as $key => $article)
                            @if (isset($paginate) && $key < $paginate)
                                @php
                                    $locale = app()->getLocale();
                                    $title = is_object($article) ? $article->translations[$locale]['title'] ?? '' : $article['translations'][$locale]['title'] ?? '';
                                    $description = is_object($article) ? $article->translations[$locale]['description'] ?? '' : $article['translations'][$locale]['description'] ?? '';
                                    $slug = is_object($article) ? $article->slug : $article['slug'] ?? '';
                                @endphp
                                <div class="article">
                                    <div class="image">
                                        @if (rand(0, 1) == 1)
                                            <img src="{{ asset('assets/images/website/projects/' . rand(1, 12) . '.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="visitor">
                                        <i class="fas fa-eye"></i>
                                        {{ is_object($article) ? $article->visitors ?? rand(254, 584) : rand(254, 584) }}
                                    </div>
                                    <div class="content">
                                        <div class="body">
                                            <a href="{{ route('blog.show', ['id' => $article->id, 'slug' => $slug]) }}" class="title font-semibold">{{ limitedText(strip_tags($title), 30) }}</a>
                                            <div class="description">{{ limitedText(strip_tags($description), 60) }}</div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn-link font-semibold details">
                                                <a href="{{ route('blog.show', ['id' => $article->id, 'slug' => $slug]) }}">
                                                    {{ __('main.details_button') }}
                                                </a>
                                            </button>
                                            <button class="btn-link font-semibold whatsapp">
                                                <a href="{{ route('tickets.index') }}">
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

            <button class="btn-link font-semibold details more" id="loadMoreBtn">
                <span>{{ __('main.more') }}</span>
            </button>

            @if ($articles && count($articles) > 0)
                <script>
                    const allArticles = @json($articles);
                    let currentPage = 1;
                    const itemsPerPage = 24;
                    const detailsButtonText = "{{ __('main.details_button') }}";
                    const whatsappButtonText = "{{ __('main.whatsapp_button') }}";
                    const locale = "{{ app()->getLocale() }}";

                    function generateArticleHTML(article, index) {
                        const randomImage = Math.random() > 0.5 ? `<img src="{{ asset('assets/images/website/projects/') }}${Math.ceil(Math.random() * 12)}.png" alt="">` : '';
                        const randomVisitors = article.visitors || Math.floor(Math.random() * (584 - 254 + 1)) + 254;

                        // Get translations safely
                        const title = article.translations && article.translations[locale] ? article.translations[locale].title : article.title || '';
                        const description = article.translations && article.translations[locale] ? article.translations[locale].description : article.description || '';
                        const slug = article.slug || '';
                        const articleId = article.id || '';
                        const articleUrl = `/blog/${articleId}/${slug}`;

                        return `
                    <div class="article">
                        <div class="image">
                            ${randomImage}
                        </div>
                        <div class="visitor">
                            <i class="fas fa-eye"></i>
                            ${randomVisitors}
                        </div>
                        <div class="content">
                            <div class="body">
                                <a href="${articleUrl}" class="title font-semibold">${title.substring(0, 30)}</a>
                                <div class="description">${description.substring(0, 60)}</div>
                            </div>
                            <div class="actions">
                                <button class="btn-link font-semibold details">
                                    <a href="${articleUrl}">
                                        ${detailsButtonText}
                                    </a>
                                </button>
                                <button class="btn-link font-semibold whatsapp">
                                    <a href="{{ route('tickets.index') }}">
                                        ${whatsappButtonText}
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    }

                    document.getElementById('loadMoreBtn').addEventListener('click', function(e) {
                        e.preventDefault();

                        const container = document.getElementById('articlesContainer');
                        const startIndex = currentPage * itemsPerPage;
                        const endIndex = startIndex + itemsPerPage;

                        if (startIndex >= allArticles.length) {
                            this.style.display = 'none';
                            return;
                        }

                        const articlesToAdd = allArticles.slice(startIndex, endIndex);

                        articlesToAdd.forEach((article, i) => {
                            const html = generateArticleHTML(article, startIndex + i);
                            container.insertAdjacentHTML('beforeend', html);
                        });

                        currentPage++;

                        if (endIndex >= allArticles.length) {
                            this.style.display = 'none';
                        }
                    });

                    // إخفاء الزر إذا كانت المقالات أقل من 25
                    if (allArticles.length <= itemsPerPage) {
                        document.getElementById('loadMoreBtn').style.display = 'none';
                    }
                </script>
            @endif
        </section>

        @if (isDebugModeEnabled())
            <div class="debug-flag-badge">🚩 flag-articles</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header.setAttribute('data-force-scrolled', 'true');
            header.classList.add('scrolled');
        });
    </script>
@endpush
