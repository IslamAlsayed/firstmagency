@extends('layouts.master')

@section('content')
    <div class="articles-page">
        <section class="articles-section">
            <div class="heading">{{ __('main.blog_archive') }}</div>

            <div class="main-articles-section">
                <div class="main-articles grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="articlesContainer">
                    @if (config('articles') && !empty(config('articles')))
                        @php
                            $paginate = 24;
                        @endphp
                        @foreach (config('articles') as $key => $article)
                            @if (isset($paginate) && $key < $paginate)
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
                                            <a href="{{ route('blog.show', ['id' => $key + 1]) }}"
                                                class="title font-semibold">{{ limitedText($article['title'], 30) }}</a>
                                            <div class="description">{{ limitedText($article['description'], 60) }}</div>
                                        </div>
                                        <div class="actions">
                                            <button class="btn-link font-semibold details">
                                                <a href="{{ route('blog.show', ['id' => $key + 1]) }}">
                                                    {{ __('main.details_button') }}
                                                </a>
                                            </button>
                                            <button class="btn-link font-semibold whatsapp">
                                                <a href="{{ route('contact') }}">
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

            @if (config('articles') && !empty(config('articles')))
                <script>
                    const allArticles = @json(config('articles'));
                    let currentPage = 1;
                    const itemsPerPage = 24;
                    const detailsButtonText = "{{ __('main.details_button') }}";
                    const whatsappButtonText = "{{ __('main.whatsapp_button') }}";

                    function generateArticleHTML(article, index) {
                        const randomImage = Math.random() > 0.5 ? `<img src="{{ asset('assets/images/projects/') }}${Math.ceil(Math.random() * 12)}.png" alt="">` : '';
                        const randomVisitors = Math.floor(Math.random() * (584 - 254 + 1)) + 254;

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
                                <a href="{{ route('blog.show', ['id' => '']) }}${index + 1}" class="title font-semibold">${article.title.substring(0, 30)}</a>
                                <div class="description">${article.description.substring(0, 60)}</div>
                            </div>
                            <div class="actions">
                                <button class="btn-link font-semibold details">
                                    <a href="{{ route('blog.show', ['id' => '']) }}${index + 1}">
                                        ${detailsButtonText}
                                    </a>
                                </button>
                                <button class="btn-link font-semibold whatsapp">
                                    <a href="{{ route('contact') }}">
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
