@extends('layouts.master')

@push('styles')
    <style>
        .seo {
            color: var(--main-color);

            & .content {
                gap: 150px;
                padding-block: 150px;
                min-height: 70svh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            & .title {
                font-size: 26px;
                font-weight: bold;
            }

            & .heading {
                font-size: 44px;
                font-weight: 900;
            }
        }

        @media (max-width: 768px) {
            .seo {
                & .content {
                    gap: 75px;
                    padding-block: 75px;
                    min-height: 70svh;

                    & .title {
                        font-size: 20px;
                    }

                    & .heading {
                        font-size: 28px;
                    }
                }
            }
        }

        @media (max-width: 425px) {
            .seo {
                & .content {
                    & .title {
                        font-size: 16px;
                    }

                    & .heading {
                        font-size: 16px;
                    }
                }
            }
        }
    </style>
@endpush

@section('content')
    <div class="seo">
        <div class="content">
            <div class="title">{{ __('main.menu_seo') }}</div>
            <div class="heading">{{ __('main.seo_coming_soon') }}</div>
        </div>
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
