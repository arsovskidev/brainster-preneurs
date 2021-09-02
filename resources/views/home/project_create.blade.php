@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'Create Project')

@section('body')

    <body>

        @include('components.navbar')

        <div class="container-fluid">
            <div class="create-edit-project">
                <form id="create_project_form">
                    <div class="row mx-5 mt-4">
                        <div class="col-md-5 p-0">
                            <h3 class="font-weight-bold">
                                New Project
                            </h3>
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="name" class="w-100 p-0" placeholder="Name of project" type="text" />
                                        <div class="bottom-line"></div>
                                    </div>
                                </div>

                                <label for="description" class="text-gray font-weight-bold mt-5 mb-3">Description of
                                    project</label>
                                <textarea id="description" class="text-muted w-100" rows="7"
                                    placeholder="Write the description for the project."></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-0">
                            <h3 class="font-weight-bold text-blue">
                                What i need
                            </h3>
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="select-project-academies">
                                            @foreach ($academies as $academy)
                                                <label>
                                                    <input type="checkbox" name="academies[]"
                                                        value="{{ $academy->id }}" />
                                                    <div class="box">
                                                        <span>{{ $academy->name }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>

                                        <div class="d-flex flex-column align-items-end">
                                            <p class="font-weight-bold text-orange fs-11 text-center m-3 mr-4">Please
                                                select no more
                                                than
                                                4
                                                options</p>
                                            <button
                                                class="
                                            btn btn-green
                                            text-uppercase
                                            font-weight-bold
                                            text-light
                                            mt-5
                                          ">
                                                create
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                alertify.set('notifier', 'position', 'bottom-left');

                $("#create_project_form").on("submit", function(e) {
                    e.preventDefault();

                    let name = $("#name").val();
                    let description = $("#description").val();

                    let academies = [];
                    $("#create_project_form input:checked").each(function() {
                        academies.push($(this).val());
                    });

                    $.ajax({
                        url: location.origin + '/api/v1/project/create',
                        type: "POST",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        data: jQuery.param({
                            name: name,
                            description: description,
                            academies: academies,
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            window.location.href = location.origin +
                                '/projects#successfully-created'

                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseJSON.data === undefined) {
                                alertify.error("There is a problem, try again later.");
                            } else {
                                alertify.error(xhr.responseJSON.data.message);
                            }
                        },
                    });
                });
            });
        </script>
    </body>
@endsection
