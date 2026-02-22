@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color);
            box-shadow: 0 0px 15px -2px rgba(0, 0, 0, 0.1);
            background-image: url('../assets/images/header-bg.png');
            background-position: center center;
            background-size: contain;
            background-repeat: repeat;
        }

        .seo {
            min-height: 70svh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: var(--main-color);

            & .heading {
                font-size: 44px;
            }
        }

        @media (max-width: 768px) {
            .seo {
                & .heading {
                    font-size: 28px;
                }
            }
        }

        @media (max-width: 425px) {
            .seo {
                & .heading {
                    font-size: 16px;
                }
            }
        }
    </style>
@endpush

@section('content')
    <div class="seo">
        <div class="heading">{{ __('main.seo_coming_soon') }}</div>
    </div>
@endsection
