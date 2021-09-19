@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'My Projects')

@section('body')

    <body class="bg-projects">

        @include('components.navbar')
        <div class="container-fluid">
            <div class="row mx-5 mt-4">
                <div class="col-md-12 p-0">
                    <h6 class="font-weight-bold">
                        Have a new idea to make the world better?
                    </h6>
                    <div class="d-flex">
                        <h3 class="font-weight-bold mr-3">Create new project</h3>
                        <a href="{{ route('project.create') }}" class="text-decoration-none">
                            <img src="/icons/1.png" alt="" style="width: 35px; height: 35px" />
                        </a>
                    </div>
                </div>
            </div>
            <div id="loader" class="text-center mt-5">
                <div class="load-dual-ring"></div>
            </div>
            <section id="projects">
            </section>
        </div>
        <script>
            $(document).ready(function() {
                if (sessionStorage.getItem("success")) {
                    alertify.success(sessionStorage.getItem("success"));
                    sessionStorage.removeItem('success');
                }
                if (sessionStorage.getItem("error")) {
                    alertify.error(sessionStorage.getItem("error"));
                    sessionStorage.removeItem('error');
                }

                show_loader();

                function render_projects(data) {
                    for (let i = 0; i < data.length; i++) {
                        let node =
                            `<div class="row project animate__animated animate__fadeIn">
                                            <div class="col-md-8 offset-md-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="text-center">
                                                                    <img class="card-img-top rounded-circle-border" src="${data[i].author.image}"
                                                                        style="width: 125px; height: 125px; margin-top: -80px" />
                                                                    <h6 class="card-title font-weight-bold m-0 mt-2">
                                                                    ${data[i].author.name} ${data[i].author.surname}
                                                                    </h6>
                                                                    <p class="fs-10 font-weight-bold text-orange mt-1">
                                                                        I'm a ${data[i].author.academy.title}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h6 class="card-title font-weight-bold m-0">
                                                                            ${data[i].name}
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="float-right" style="margin-top: -60px">
                                                                            <div id="${data[i].id}" class="green-circle show_project" role="button">
                                                                                <div class="text-center fs-24 mt-2">${data[i].applications}</div>
                                                                                <div class="text-center fs-11">Applicants</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <p class="fs-11 mt-3">
                                                                            <span class='short_description'>${data[i].description.substr(0, 250) + "..."}</span>
                                                                            <span class='description d-none'>${data[i].description}</span>
                                                                        </p>
                                                                        <div class="text-orange">
                                                                            <div class="more text-orange fs-11 float-right mb-3" role="button">show more</div>
                                                                            <div class="less text-orange fs-11 float-right mb-3 d-none" role="button">show less</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 mt-auto" style="margin-bottom: -20px">
                                                                <p class="fs-10 font-weight-bold text-center">
                                                                    I'am looking for
                                                                </p>
                                                                <div class="d-flex justify-content-center text-center">`;


                        if (data[i].academies != undefined) {
                            for (let x = 0; x < data[i].academies.length; x++) {
                                node += `
                                            <div class="half-green-circle">
                                                <p class="text-light font-weight-bold fs-8 mt-2">
                                                    ${data[i].academies[x].short}
                                                </p>
                                            </div>`;
                            }
                            node += `</div>
                                    </div>`;
                        }

                        if (data[i].status == 'started') {
                            node += `
                                <div class="col-md-8 mt-4">
                                        <div class="shield down float-right mr-4">
                                            <div class="content">
                                                <div class="dot"></div>
                                            </div>
                                        </div>
                                </div>`;
                        }
                        node += `</div>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-1 project-actions animate__animated my-auto mt-5 text-center" style="display: none;">
                                    <div class="d-md-flex flex-column">
                                        <a href="/projects/edit/${data[i].id}"><img src="/icons/8.png" alt="" style="width: 23px; height: 23px"
                                                class="my-3" /></a>
                                        <div id="${data[i].id}" class="btn delete_button"><img src="/icons/7.png" alt="" style="width: 25px; height: 25px"
                                                class="my-3" /></div>
                                    </div>
                                </div>
                            </div>`;
                        $("#projects").append(node);
                    }
                }

                $.ajax({
                    url: '/api/v1/account/projects',
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            'Bearer {{ Session::get('access_token') }}');
                    },
                    data: {},
                    success: function(data) {
                        hide_loader();
                        render_projects(data.data);
                    },
                    error: function(xhr, status, error) {
                        show_loader();
                        if (xhr.responseJSON.data === undefined) {
                            alertify.error("There is a problem, try again later.");
                        } else {
                            alertify.error(xhr.responseJSON.data.message);
                        }
                    }
                });

                // Project hover
                $(document).on('mouseenter', '.project', function() {
                    let actions = $(this).find('.project-actions');

                    actions.addClass('animate__fadeInLeft');
                    actions.show();
                });
                $(document).on('mouseleave', '.project', function() {
                    let actions = $(this).find('.project-actions');

                    actions.removeClass('animate__fadeInLeft');
                    actions.hide();
                });

                // Show more
                $(document).on('click', ".more", function() {
                    $(this).parent().parent().find('.description').removeClass('d-none')
                    $(this).parent().parent().find('.short_description').addClass('d-none')


                    $(this).parent().parent().find('.more').addClass('d-none')
                    $(this).parent().parent().find('.less').removeClass('d-none')
                });
                // Show less
                $(document).on('click', ".less", function() {
                    $(this).parent().parent().find('.description').addClass('d-none')
                    $(this).parent().parent().find('.short_description').removeClass('d-none')

                    $(this).parent().parent().find('.more').removeClass('d-none')
                    $(this).parent().parent().find('.less').addClass('d-none')
                });

                // Delete project
                $(document).on('click', '.delete_button', function() {
                    let id = $(this).attr('id');

                    $.ajax({
                        url: location.origin + '/api/v1/project/delete/' + id,
                        type: 'DELETE',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        success: function(data) {
                            alertify.success(data.data);
                            $("#" + id + ".delete_button").parent().parent().parent().hide(750);
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

                // Show project
                $(document).on('click', ".show_project", function() {
                    let id = $(this).attr('id');
                    location.href = "/projects/" + id;
                });

                // Loader
                function show_loader() {
                    $("#loader").removeClass('d-none');
                }

                function hide_loader() {
                    $("#loader").addClass('d-none');
                }
            });
        </script>
        @if (\Session::has('error'))
            <script>
                alertify.error("{{ Session::get('error') }}");
            </script>
        @endif
    </body>
@endsection
