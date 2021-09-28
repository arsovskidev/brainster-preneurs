@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'My Projects')

@section('body')

    <body>

        @include('components.navbar')
        <div class="container-fluid">
            <div class="row mx-5 mt-4">
                <div class="col-md-9 p-0">
                    <h3 class="font-weight-bold">
                        {{ $project->name }} - Applicants
                    </h3>
                    <div class="d-flex my-3">
                        <h6 class="font-weight-bold mr-3">Choose your teammates</h6>
                        <img src="/icons/4.png" alt="" style="width: 35px; height: 35px" class="ml-4 mt-2" />
                    </div>
                </div>
                <div class="col-md-3 p-0">
                    <div class="d-flex flex-column align-items-center">
                        <p class="text-muted font-weight-bold fs-11 m-0">
                            Ready to start?
                        </p>
                        <p class="text-muted font-weight-bold fs-11 m-0">
                            Click on the button below
                        </p>
                        <button class="btn btn-orange start_button text-uppercase font-weight-bold mt-3"
                            {{ $project->status === 'started' ? 'disabled' : '' }}>team assembled
                            <i class="fas fa-check ml-2"></i></button>
                    </div>
                </div>
            </div>
            <div class="row mx-5">
                <div class="col-md-10 offset-md-1 p-0">
                    <div class="cards-container">
                        <div class="row justify-content-center">
                            @foreach ($applications as $applicant)
                                @if ($applicant->pivot->status != 'denied')
                                    <div class="col-lg-4 col-md-6 card-holder">
                                        <div id="{{ $applicant->id }}"
                                            class="card {{ $applicant->pivot->status === 'accepted' ? 'bg-gray' : '' }}">
                                            <img class="card-img-top rounded-circle-border mx-auto"
                                                src="{{ $applicant->image }}" alt=""
                                                style="width: 150px; height: 150px; margin-top: -80px" />
                                            <div class="card-body text-center">
                                                <a href="{{ route('profile.show', $applicant->id) }}"
                                                    class="text-decoration-none">
                                                    <h5 class="card-title text-blue font-weight-bold">
                                                        {{ $applicant->name }}
                                                        {{ $applicant->surname }}</h5>
                                                </a>
                                                <h6 class="text-orange font-weight-bold">{{ $applicant->academy->title }}
                                                </h6>
                                                <p class="fs-10 text-muted">{{ $applicant->email }}</p>
                                                <p class="card-text text-blue font-weight-bold fs-12">
                                                    {{ $applicant->pivot->message }}</p>
                                                <button id="{{ $applicant->id }}" class="btn accept_button"
                                                    {{ $applicant->pivot->status === 'accepted' ? 'disabled' : '' }}>
                                                    <img src="/icons/1.png" alt="" style="width: 25px; height: 25px;">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                let project_id = {{ $project->id }};

                $(document).on('click', '.accept_button', function() {
                    let id = $(this).attr('id');

                    $.ajax({
                        url: '/api/v1/project/' + project_id + '/accept/' + id,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        success: function(data) {
                            alertify.success(data.data.message);
                            $("#" + id + ".accept_button").attr("disabled", true);
                            $(".card#" + id).addClass("bg-gray");
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseJSON.data === undefined) {
                                alertify.error("There is a problem, try again later.");
                            } else {
                                alertify.error(xhr.responseJSON.data.message);
                            }
                        }
                    });

                });

                $(document).on('click', '.start_button', function() {
                    $.ajax({
                        url: '/api/v1/project/' + project_id + '/start/',
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        success: function(data) {
                            alertify.success(data.data.message);
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseJSON.data === undefined) {
                                alertify.error("There is a problem, try again later.");
                            } else {
                                alertify.error(xhr.responseJSON.data.message);
                            }
                        }
                    });

                });
            });
        </script>
    </body>
@endsection
