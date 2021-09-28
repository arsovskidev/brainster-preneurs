@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}" />
@endsection

@section('title', 'Register')

@section('body')

    <body>
        <section id="step-one" class="animate__animated d-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="register">
                            <form id="step_one_form">
                                <div class="display-4 font-weight-bold text-blue mb-4">
                                    Register
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input id="name" placeholder="Name" type="text" required />
                                        <div class="bottom-line"></div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <input id="surname" placeholder="Surname" type="text" required />
                                        <div class="bottom-line"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input id="email" placeholder="Email" type="text" required />
                                        <div class="bottom-line"></div>
                                    </div>
                                    <div class="col-md-5 offset-md-2">
                                        <input id="password" placeholder="Password" type="password" required />
                                        <div class="bottom-line"></div>
                                    </div>
                                </div>
                                <h5 class="text-gray mt-5 mb-3">Biography</h5>
                                <textarea id="biography" rows="6" placeholder="Write your biography." required></textarea>
                                <p id="characters_left" class="fs-11 text-right"></p>
                                <button class="btn btn-green text-uppercase font-weight-bold text-light">
                                    next
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="step-two" class="animate__animated d-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="register">
                            <form id="step_two_form">
                                <div class="row align-items-center">
                                    <div class="col-xl-4">
                                        <div class="display-4 font-weight-bold text-blue mb-4">
                                            Academies
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="header-orange-line"></div>
                                    </div>
                                </div>
                                <h5 class="font-weight-light">
                                    Please select one of the academies listed below
                                </h5>

                                <div class="select-academy">
                                    @foreach ($academies as $academy)
                                        <label>
                                            <input type="radio" name="academy" value="{{ $academy->id }}" />
                                            <div class="box">
                                                <span>{{ $academy->name }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-column align-items-end">
                                    <button
                                        class="
                                btn btn-green
                                text-uppercase
                                font-weight-bold
                                text-light
                              ">
                                        next
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="step-three" class="animate__animated d-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="register">
                            <form id="step_three_form">
                                <div class="row align-items-center">
                                    <div class="col-xl-2">
                                        <div class="display-4 font-weight-bold text-blue mb-4">
                                            Skills
                                        </div>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="header-orange-line"></div>
                                    </div>
                                </div>
                                <h5 class="font-weight-light">Please select your skills set</h5>

                                <div class="select-skills">
                                    @foreach ($skills as $skill)
                                        <label>
                                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" />
                                            <div class="box">
                                                <span>{{ $skill->name }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-column align-items-end">
                                    <button
                                        class="
                                btn btn-green
                                text-uppercase
                                font-weight-bold
                                text-light
                              ">
                                        next
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="step-four" class="animate__animated d-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="register">
                            <form id="step_four_form">
                                <div class="row align-items-center">
                                    <div class="col-xl-6">
                                        <div class="display-4 font-weight-bold text-blue mb-4">
                                            Your profile image
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="header-orange-line"></div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column align-items-center">
                                    <input accept="image/*" type="file" id="image" name="image" hidden />
                                    <label class="h4 font-weight-light my-5 d-flex flex-column align-items-center"
                                        for="image">
                                        <img id="profileImagePreview" class="rounded-circle mt-3 mb-3"
                                            src="{{ asset('icons/9.png') }}" style="width: 200px; height: 200px" />
                                        Click here to upload an image
                                    </label>

                                    <button
                                        class="
                                btn btn-green
                                text-uppercase
                                font-weight-bold
                                text-light
                              ">
                                        finish
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function() {

                alertify.set('notifier', 'position', 'top-right');

                // Registration Step Checking.
                let step = "{{ $step }}";
                if (step === "step-one") {
                    $("body").addClass("bg-register");
                    $("#step-one").removeClass("d-none");
                    $("#step-one").addClass("animate__fadeIn");
                } else if (step === "step-two") {
                    $("#step-two").removeClass("d-none");
                    $("#step-two").addClass("animate__fadeIn");
                } else if (step === "step-three") {
                    $("#step-three").removeClass("d-none");
                    $("#step-three").addClass("animate__fadeIn");
                } else if (step === "step-four") {
                    $("#step-four").removeClass("d-none");
                    $("#step-four").addClass("animate__fadeIn");
                }

                // Biography characters.

                checkTextAreaCount()

                $('#biography').keyup(function() {
                    checkTextAreaCount();
                });

                function checkTextAreaCount() {
                    if ($('#biography').val().length <= 1000) {
                        $('#characters_left').removeClass("text-red")
                        $('#characters_left').text((1000 - $('#biography').val().length) + " characters left");
                    } else {
                        $('#characters_left').addClass("text-red")
                        $('#characters_left').text(($('#biography').val().length - 1000) + " characters exceeded");
                    }
                }
                // Profile Image Preview.
                image.onchange = (evt) => {
                    const [file] = image.files;
                    if (file) {
                        profileImagePreview.src = URL.createObjectURL(file);
                    }
                };

                // Step One
                $("#step_one_form").on("submit", function(e) {
                    e.preventDefault();

                    let name = $("#step_one_form #name");
                    let surname = $("#step_one_form #surname");
                    let biography = $("#step_one_form #biography");
                    let email = $("#step_one_form #email");
                    let password = $("#step_one_form #password");

                    $.ajax({
                        url: "/register/step-one",
                        type: "POST",
                        data: jQuery.param({
                            name: name.val(),
                            surname: surname.val(),
                            biography: biography.val(),
                            email: email.val(),
                            password: password.val(),
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            alertify.success(data.data.message);

                            $("body").removeClass("bg-register");
                            $("#step-one").addClass("animate__fadeOut");

                            setTimeout(function() {
                                $("#step-one").addClass("d-none");

                                $("#step-two").removeClass("d-none");
                                $("#step-two").addClass("animate__fadeIn");
                            }, 1000);
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

                // Step Two
                $("#step_two_form").on("submit", function(e) {
                    e.preventDefault();

                    let academy = $("#step_two_form input[name='academy']:checked");

                    $.ajax({
                        url: "/register/step-two",
                        type: "POST",
                        data: jQuery.param({
                            academy: academy.val(),
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            alertify.success(data.data.message);

                            $("#step-two").addClass("animate__fadeOut");

                            setTimeout(function() {
                                $("#step-two").addClass("d-none");

                                $("#step-three").removeClass("d-none");
                                $("#step-three").addClass("animate__fadeIn");
                            }, 1000);
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

                // Step Three
                $("#step_three_form").on("submit", function(e) {
                    e.preventDefault();

                    let skills = [];
                    $("#step_three_form input:checked").each(function() {
                        skills.push($(this).val());
                    });

                    $.ajax({
                        url: "/register/step-three",
                        type: "POST",
                        data: jQuery.param({
                            skills: skills,
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            alertify.success(data.data.message);

                            $("#step-three").addClass("animate__fadeOut");

                            setTimeout(function() {
                                $("#step-three").addClass("d-none");

                                $("#step-four").removeClass("d-none");
                                $("#step-four").addClass("animate__fadeIn");
                            }, 1000);
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

                // Step Four
                $("#step_four_form").on("submit", function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);

                    $.ajax({
                        url: "/register/step-four",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            alertify.success(data.data.message);

                            $("#step-four").addClass("animate__fadeOut");

                            setTimeout(function() {
                                window.location.replace('/');
                            }, 1000);
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
