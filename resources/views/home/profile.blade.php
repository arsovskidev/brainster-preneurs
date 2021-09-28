@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'My Profile')

@section('body')

    <body>

        @include('components.navbar')

        <div class="container-fluid">
            <div class="create-edit">
                <form id="edit_profile_form">
                    <div class="row mx-5">
                        <div class="col-md-5 p-0 mt-4">
                            <h3 class="font-weight-bold">
                                My Profile
                            </h3>
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-6 text-center">

                                        <input accept="image/*" type="file" id="image" name="image" hidden />
                                        <label class="h4 font-weight-light fs-12 d-flex flex-column align-items-center"
                                            for="image">
                                            <img id="profileImagePreview" src="{{ $profile->image }}"
                                                class="rounded-circle-border mb-3" alt=""
                                                style="width: 125px; height: 125px;">
                                            Click here to upload an image
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="name" class="text-muted w-100 p-0" placeholder="Your Name" type="text"
                                            value="{{ $profile->name }}" />
                                        <div class="bottom-line"></div>
                                        <input name="surname" class="text-muted w-100 p-0" placeholder="Your Name"
                                            type="text" value="{{ $profile->surname }}" />
                                        <div class="bottom-line"></div>
                                        <input class="text-muted w-100 p-0" type="text" value="{{ $profile->email }}"
                                            disabled />
                                        <div class="bottom-line"></div>
                                    </div>
                                </div>

                                <label for="biography" class="text-gray font-weight-bold mt-5 mb-3">Biography</label>
                                <textarea name="biography" id="biography" class="text-muted w-100" rows="5"
                                    placeholder="Please write your biography.">{{ $profile->biography }}</textarea>
                                <p id="characters_left" class="fs-11 text-right"></p>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-1 p-0 mt-4">
                            <h3 class="font-weight-bold text-blue">
                                Skills
                            </h3>
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="select-skills">
                                            @foreach ($skills as $skill)
                                                <label>
                                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}"
                                                        {{ in_array($skill->id, $profile->skills->pluck('id')->toArray()) ? 'checked' : '' }} />
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
                                            mt-5
                                          ">
                                                edit
                                            </button><a href="{{ route('logout') }}"
                                                class="btn btn-sm btn-logout text-uppercase">
                                                logout
                                            </a>
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

                alertify.set('notifier', 'position', 'bottom-right');

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

                $("#edit_profile_form").on("submit", function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: location.origin + '/api/v1/profile/edit',
                        type: "POST",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('Authorization',
                                'Bearer {{ Session::get('access_token') }}');
                        },
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
                        },
                    });
                });
            });
        </script>
    </body>
@endsection
