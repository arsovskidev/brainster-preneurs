@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', "$profile->name $profile->surname")

@section('body')

    <body>

        @include('components.navbar')

        <div class="container-fluid">
            <div class="row mx-5 mt-5">
                <div class="col-md-5 p-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <img src="{{ $profile->image }}" class="rounded-circle" alt=""
                                    style="width: 200px; height: 200px;">
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <h5 class="font-weight-bold text-gray">Name:</h5>
                            <h2 class="font-weight-bold">{{ $profile->name }} {{ $profile->surname }}</h2>
                            <h5 class="font-weight-bold text-gray mt-4">Contact:</h5>
                            <h5 class="font-weight-bold">{{ $profile->email }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-md-1 p-0">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <h5 class="font-weight-bold text-gray">Biography:</h5>
                            <div class="text-break">
                                @if (strlen($profile->biography) > 250)
                                    <p class='text-gray short_biography'>
                                        {{ substr($profile->biography, 0, 250) . '...' }}
                                    </p>
                                    <p class='text-gray biography d-none'>
                                        {{ $profile->biography }}
                                    </p>
                                    <div class="text-orange">
                                        <div class="more text-orange fs-11 float-right mb-3" role="button">
                                            show more
                                        </div>
                                        <div class="less text-orange fs-11 float-right mb-3 d-none" role="button">
                                            show less
                                        </div>
                                    </div>
                                @else
                                    <p class='text-gray'>
                                        {{ $profile->biography }}
                                    </p>
                                @endif
                            </div>
                            <h5 class="font-weight-bold text-gray mt-5">Skills:</h5>
                            <div class="d-flex flex-wrap text-center">
                                @foreach ($profile->skills as $skill)
                                    <div class="skill-box mr-4 mt-2">{{ $skill->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-5">
                <div class="col-md-12">
                    <div class="d-flex flex-column align-items-start">
                        <a href="{{ url()->previous() }}"
                            class="
                        btn btn-green
                        text-uppercase
                        font-weight-bold
                        text-light
                        mt-5
                      "
                            style="height: 40px;">
                            back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                alertify.set('notifier', 'position', 'bottom-left');

                // Show more
                $(document).on('click', ".more", function() {
                    $(this).parent().parent().find('.biography').removeClass('d-none')
                    $(this).parent().parent().find('.short_biography').addClass('d-none')


                    $(this).parent().parent().find('.more').addClass('d-none')
                    $(this).parent().parent().find('.less').removeClass('d-none')
                });
                // Show less
                $(document).on('click', ".less", function() {
                    $(this).parent().parent().find('.biography').addClass('d-none')
                    $(this).parent().parent().find('.short_biography').removeClass('d-none')

                    $(this).parent().parent().find('.more').removeClass('d-none')
                    $(this).parent().parent().find('.less').addClass('d-none')
                });

            });
        </script>
    </body>
@endsection
