@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'Home')

@section('body')

    <body class="bg-home">

        @include('components.navbar-lite')

        <div class="container-fluid">
            <div class="row mx-5 mt-5">
                <div class="col-xl-4 position-fixed p-0">
                    <h6 class="font-weight-bold">In what field can you be amazing?</h6>
                    <div class="row">
                        <div class="col-md-8 col-10">
                            <div id="project_filters" class="project-filter">
                                <label>
                                    <input type="radio" name="project-filter" value="0" checked />
                                    <div class="box">
                                        <span>All</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 offset-xl-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mb-5">
                                <img src="{{ asset('/icons/3.png') }}" alt=""
                                    style="width: 35px; height: 35px; margin-top: 7px; margin-right: 5px;" />
                                <h6 class="font-weight-bold">Checkout the latest projects</h6>
                            </div>
                            <section id="projects">
                            </section>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="pagination" class="btn btn-orange mt-5 d-none">Show more</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Apply Modal -->
        <div class="modal fade" id="apply_modal" tabindex="-1" role="dialog" aria-labelledby="apply_modal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Apply</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="apply_status"></div>
                        <form id="apply_form">
                            <input id="project_id" type="hidden" value="0" />
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea type="text" class="form-control" id="message" rows="5"
                                    placeholder="Write here why you want to join this project."></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-project-green">Apply</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                let next_page;

                function render_projects(data) {
                    for (let i = 0; i < data.length; i++) {
                        setTimeout(function() {
                            let node = `<div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img class="card-img-top rounded-circle" src="${data[i].author.image}"
                                                    style="width: 100px; height: 100px; margin-top: -80px" />
                                                <h6 class="card-title font-weight-bold m-0 mt-2">
                                                    ${data[i].author.name} ${data[i].author.surname}
                                                </h6>
                                                <p class="fs-10 font-weight-bold text-orange mt-1">
                                                    ${data[i].author.academy.name}
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
                                                            <div id="${data[i].id}" class="text-center applications_count fs-24 mt-2">${data[i].applications}</div>
                                                            <div class="text-center fs-11">Applicants</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="fs-11 mt-3">
                                                        <span id='short_description'>${data[i].short_description}</span>
                                                        <span id='description' class='d-none'>${data[i].description}</span>
                                                    </p>
                                                    <div class="text-orange">
                                                        <button id="more" class="btn text-orange fs-11 float-right mb-3">show more</button>
                                                        <button id="less" class="btn text-orange fs-11 float-right mb-3 d-none">show less</button>
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
                                            <div class="d-flex justify-content-center text-center">`


                            if (data[i].academies != undefined) {
                                for (let x = 0; x < data[i].academies.length; x++) {
                                    node += `
                                            <div class="half-green-circle">
                                                <p class="text-light font-weight-bold fs-8 mt-2">
                                                    ${data[i].academies[x].name}
                                                </p>
                                            </div>`;
                                }
                            }

                            node += `</div>
                            </div>
                            <div class="col-md-8 mt-4">`;

                            if (data[i].available) {
                                node +=
                                    `<button id="${data[i].id}" class="btn btn-project-green apply_button text-uppercase float-right">i 'm in</button>`;
                            } else {
                                node +=
                                    `<button class="btn btn-project-green text-uppercase float-right" disabled>i 'm in</button>`;
                            }
                            node += `
                            </div>
                            </div>
                            </div>
                            </div>`;

                            $("#projects").append(node);
                        }, 200 * i);
                    }

                }

                // List Filter Academies
                $.ajax({
                    url: '/api/v1/academies',
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            'Bearer {{ Session::get('access_token') }}');
                    },
                    data: {},
                    success: function(data) {
                        for (let i = 0; i < data.data.length; i++) {
                            let node = `<label>
                                        <input type="radio" name="project-filter" value="${data.data[i].id}" />
                                        <div class="box">
                                            <span>${data.data[i].name}</span>
                                        </div>
                                    </label>`;

                            $("#project_filters").append(node);
                        }

                    },
                    error: function(xhr, status, error) {
                        alertify.error(xhr.responseJSON.data)
                    }
                });

                // List projects
                $.ajax({
                    url: '/api/v1/projects',
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization',
                            'Bearer {{ Session::get('access_token') }}');
                    },
                    data: {},
                    success: function(data) {
                        render_projects(data.data)
                        next_page = data.links.next;

                        if (next_page != null) {
                            $("#pagination").removeClass('d-none');
                        }

                    },
                    error: function(xhr, status, error) {
                        alertify.error(xhr.responseJSON.data)
                    }
                });

                // Project Filter
                $(document).on('change', "input[name='project-filter']", function(e) {
                    let academy = $("input[name='project-filter']:checked");
                    let url;
                    if (academy.val() != 0) {
                        url = '/api/v1/projects/academy/' + academy.val();
                    } else {
                        url = '/api/v1/projects';
                    }
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        data: {},
                        success: function(data) {
                            $('#projects').html('');
                            render_projects(data.data)
                            next_page = data.links.next;

                            if (next_page != null) {
                                $("#pagination").removeClass('d-none');
                            }

                        },
                        error: function(xhr, status, error) {
                            $('#projects').html('');
                            alertify.error(xhr.responseJSON.data)
                        }
                    });
                });

                // Pagination
                $("#pagination").click(function() {
                    $.ajax({
                        url: next_page,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        data: {},
                        success: function(data) {
                            render_projects(data.data)
                            next_page = data.links.next

                            if (next_page == null) {
                                $("#pagination").addClass('d-none');
                            }

                        },
                        error: function(xhr, status, error) {
                            alertify.error(
                                'There is an error with the server, please try again later.'
                            );
                        }
                    });


                });

                // Show more
                $(document).on('click', "#more", function() {
                    $(this).parent().parent().find('#description').removeClass('d-none')
                    $(this).parent().parent().find('#short_description').addClass('d-none')


                    $(this).parent().parent().find('#more').addClass('d-none')
                    $(this).parent().parent().find('#less').removeClass('d-none')
                });
                // Show less
                $(document).on('click', "#less", function() {
                    $(this).parent().parent().find('#description').addClass('d-none')
                    $(this).parent().parent().find('#short_description').removeClass('d-none')

                    $(this).parent().parent().find('#more').removeClass('d-none')
                    $(this).parent().parent().find('#less').addClass('d-none')
                });

                // Apply Modal
                $(document).on('click', '.apply_button', function() {
                    let id = $(this).attr('id');

                    $('#apply_status').html("")
                    $('#apply_form #project_id').attr('value', id);
                    $('#apply_modal').modal('show');

                });

                // Apply Form
                $("#apply_form").on('submit', function(e) {
                    e.preventDefault();

                    let id = $('#apply_form #project_id').val();
                    let message = $('#apply_form #message');

                    $.ajax({
                        url: '/api/v1/project/apply/' + id,
                        type: 'POST',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        data: jQuery.param({
                            message: message.val(),
                        }),
                        success: function(data) {
                            alertify.success(data.data);
                            $("#" + id + ".apply_button").attr("disabled", true);

                            let current_applications_count = $(".applications_count#" + id).text();
                            $(".applications_count#" + id).text(parseInt(
                                current_applications_count) + 1);

                            $("#apply_modal").modal('hide');
                        },
                        error: function(xhr, status, error) {
                            let node = '<div class="alert alert-danger">'

                            $.each(xhr.responseJSON.data.messages, function(key, value) {
                                node += `<div>${value[0]}</div>`
                            });
                            node += '</div>'
                            $('#apply_status').html(node)
                        }
                    });

                });

            });
        </script>
    </body>
@endsection
