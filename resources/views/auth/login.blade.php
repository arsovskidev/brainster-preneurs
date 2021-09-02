@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}" />
@endsection

@section('title', 'Login')

@section('body')

    <body class="bg-login">
        <div class="container ">
            <div class="row">
                <div class="col-md-9">
                    <div class="login-hero">
                        <div class="d-flex mb-4">
                            <h2 class="text-uppercase font-weight-bold text-blue">brainster</h2>
                            <h2 class="text-uppercase font-weight-bold text-gray">preneurs</h2>
                        </div>
                        <h3 class="text-blue">Propel your ideas to life!</h3>
                    </div>
                </div>
                <div class="col-md-3 mb-5">
                    <form id="login_form" class="login-form">
                        <h1 class="font-weight-bold">Login</h1>
                        <input id="email" placeholder="Email" type="text" required />
                        <div class="bottom-line"></div>
                        <input id="password" placeholder="Password" type="password" required />
                        <div class="bottom-line"></div>
                        <div class="text-right">
                            <button class="btn btn-orange text-uppercase font-weight-bold text-light">
                                login
                            </button>
                        </div>
                        <div class="text-center">
                            <small>Don't have an account, register
                                <a href="{{ route('register') }}">here!</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                alertify.set('notifier', 'position', 'top-right');

                $("#login_form").on("submit", function(e) {
                    e.preventDefault();

                    let email = $("#login_form #email");
                    let password = $("#login_form #password");

                    $.ajax({
                        url: "/login",
                        type: "POST",
                        data: jQuery.param({
                            email: email.val(),
                            password: password.val(),
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(data) {
                            window.location.replace('/');
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
