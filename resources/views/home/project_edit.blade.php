@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'Edit Project')

@section('body')

    <body>

        @include('components.navbar')

        <div class="container-fluid">
            <div class="create-edit">
                <form id="edit_project_form">
                    <div class="row mx-5 mt-4">
                        <div class="col-md-5 p-0">
                            <h3 class="font-weight-bold">
                                Edit Project
                            </h3>
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="name" class="w-100 p-0" placeholder="Name of project" type="text"
                                            value="{{ $project->name }}" />
                                        <div class="bottom-line"></div>
                                    </div>
                                </div>

                                <label for="description" class="text-gray font-weight-bold mt-5 mb-3">Description of
                                    project</label>
                                <textarea id="description" class="text-muted w-100" rows="7"
                                    placeholder="Write the description for the project.">{{ $project->description }}</textarea>
                                <p id="characters_left" class="fs-11 text-right"></p>
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
                                                    <input type="checkbox" name="academies[]" value="{{ $academy->id }}"
                                                        {{ in_array($academy->id, $project->academies->pluck('id')->toArray()) ? 'checked' : '' }} />

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
                                                edit
                                            </button>
                                        </div>
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

                // Description characters.
                checkTextAreaCount()

                $('#description').keyup(function() {
                    checkTextAreaCount();
                });

                function checkTextAreaCount() {
                    if ($('#description').val().length <= 1000) {
                        $('#characters_left').removeClass("text-red")
                        $('#characters_left').text((1000 - $('#description').val().length) + " characters left");
                    } else {
                        $('#characters_left').addClass("text-red")
                        $('#characters_left').text(($('#description').val().length - 1000) + " characters exceeded");
                    }
                }

                $("#edit_project_form").on("submit", function(e) {
                    e.preventDefault();

                    let name = $("#name").val();
                    let description = $("#description").val();

                    let academies = [];
                    $("#edit_project_form input:checked").each(function() {
                        academies.push($(this).val());
                    });

                    $.ajax({
                        url: location.origin + '/api/v1/project/edit/{{ $project->id }}',
                        type: "PUT",
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
                            sessionStorage.setItem('success', 'Project successfully edited!');
                            window.location.href = location.origin + '/projects'

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
