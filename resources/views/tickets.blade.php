@extends('layouts.master')

@section('content')
    <div class="contact-sections tickets-section">
        <div class="text">
            <div class="title font-semibold mb-4">اكتب البريد الالكتروني الخاص بك والمسجل بة التذاكر للاستعلام عن الطلب</div>
        </div>

        <div class="container tickets-form">
            {{-- <div class="heading">استعلام عن طلبك / تذكرتك</div> --}}
            <h2>استعلام عن طلبك / تذكرتك</h2>

            <div class="group-tickets">
                <div>
                    <label for="email" class="font-semibold">
                        البريد الإلكتروني
                        <span class="text-red-600">*</span>
                    </label>

                    <div class="input flex">
                        <input type="email" id="email" placeholder="example@domain.com">
                    </div>
                </div>

                <button class="btn-link light-main-color font-semibold mb-8">
                    عرض التذاكر
                </button>
            </div>
        </div>
    </div>
@endsection
