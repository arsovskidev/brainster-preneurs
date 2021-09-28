@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'My Applications')

@section('body')

    <body class="bg-applications">

        @include('components.navbar')
        <div class="container-fluid">
            <div class="row mx-5 mt-4">
                <div class="col-md-12 p-0">
                    <h3 class="font-weight-bold mr-3">My Applications</h3>
                </div>
            </div>
            <div id="loader" class="text-center mt-5">
                <div class="load-dual-ring"></div>
            </div>
            <section id="applications">
            </section>
        </div>
        <script>
            $(document).ready(function() {
                show_loader();

                function render_projects(data) {
                    for (let i = 0; i < data.length; i++) {
                        let node =
                            `<div class="row application animate__animated animate__fadeIn">
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
                                                                            <div class="green-circle">
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
                        }
                        node += `</div>
                                    </div>`;

                        if (data[i].status == 'accepted') {
                            node += `
                                <div class="col-md-8 mt-5 mb-2">
                                    <div class="row">
                                        <div class="col-10 col-md-5 my-auto">
                                            <h6 class="text-green m-0">Application Accepted</h6>
                                        </div>
                                        <div class="col-2 col-md-7 p-0">
                                            <img src="/icons/5.png" alt="" style="width: 25px; height: 25px" />
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>`;
                        } else {
                            if (data[i].status == 'denied') {
                                node += `<div class="col-md-8 mt-5 mb-2">
                                    <div class="row">
                                        <div class="col-10 col-md-5 my-auto">
                                            <h6 class="text-red m-0">Application Denied</h6>
                                        </div>
                                        <div class="col-2 col-md-7 p-0">
                                            <img src="/icons/6.png" alt="" style="width: 25px; height: 25px" />
                                        </div>
                                    </div>
                                </div>`;
                            }
                            node += `</div>
                                </div>
                                </div>
                                </div>
                                <div class="col-md-1 project-actions animate__animated my-auto mt-5 text-center" style="display: none;">
                                    <div id="${data[i].id}" class="d-md-flex flex-column btn cancel_button">
                                        <img src="/icons/2.png" alt="" class="m-auto" style="width: 20px; height: 20px" />
                                        <span class="text-muted fs-12">Cancel</span>
                                    </div>
                                </div>
                            </div>`;
                        }
                        $("#applications").append(node);
                    }
                }

                $.ajax({
                    url: '/api/v1/account/applications',
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            'Bearer {{ Session::get('access_token') }}');
                    },
                    data: {},
                    success: function(data) {
                        render_projects(data.data);
                        hide_loader();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON.data === undefined) {
                            alertify.error("There is a problem, try again later.");
                        } else {
                            alertify.error(xhr.responseJSON.data.message);
                        }
                    }
                });

                // Project hover
                $(document).on('mouseenter', '.application', function() {
                    let actions = $(this).find('.project-actions');

                    actions.addClass('animate__fadeInLeft');
                    actions.show();
                });
                $(document).on('mouseleave', '.application', function() {
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

                // Cancel application
                $(document).on('click', '.cancel_button', function() {
                    let id = $(this).attr('id');

                    $.ajax({
                        url: location.origin + '/api/v1/project/cancel/' + id,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        success: function(data) {
                            alertify.success(data.data.message);
                            $("#" + id + ".cancel_button").parent().parent().parent().hide(750);
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

                // Loader
                function show_loader() {
                    $("#loader").removeClass('d-none');
                }

                function hide_loader() {
                    $("#loader").addClass('d-none');
                }
            });
        </script>
    </body>
@endsection
