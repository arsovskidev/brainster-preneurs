@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login-register.css') }}" />
@endsection

@section('title', 'Register')

@section('body')
<body>
  <section id="step-one" class="d-none">
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
                  <input id="name" placeholder="Name" type="text" />
                  <div class="bottom-line"></div>
                </div>
                <div class="col-md-5 offset-md-2">
                  <input id="surname" placeholder="Surname" type="text" />
                  <div class="bottom-line"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <input id="email" placeholder="Email" type="text" />
                  <div class="bottom-line"></div>
                </div>
                <div class="col-md-5 offset-md-2">
                  <input id="password" placeholder="Password" type="password" />
                  <div class="bottom-line"></div>
                </div>
              </div>
              <h5 class="text-gray mt-5 mb-3">Biography</h5>
              <textarea
                id="biography"
                rows="6"
                placeholder="Write your biography."
              ></textarea>
              <button
                id="submit"
                class="btn btn-green text-uppercase font-weight-bold text-light"
              >
                next
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="step-two" class="d-none">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="register">
            <form>
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
                <label>
                  <input type="radio" name="academy" value="0" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="1" />
                  <div class="box">
                    <span>Frontend Development</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="2" />
                  <div class="box">
                    <span>Marketing</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="3" />
                  <div class="box">
                    <span>Data Science</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="4" />
                  <div class="box">
                    <span>Design</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="5" />
                  <div class="box">
                    <span>QA</span>
                  </div>
                </label>
                <label>
                  <input type="radio" name="academy" value="6" />
                  <div class="box">
                    <span>UX/UI</span>
                  </div>
                </label>
              </div>

              <div class="d-flex flex-column align-items-end">
                <button
                  class="
                    btn btn-green
                    text-uppercase
                    font-weight-bold
                    text-light
                  "
                >
                  next
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="step-three" class="d-none">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="register">
            <form>
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
                <label>
                  <input type="checkbox" name="skills[]" value="0" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="checkbox" name="skills[]" value="1" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="checkbox" name="skills[]" value="1" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="checkbox" name="skills[]" value="1" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="checkbox" name="skills[]" value="1" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
                <label>
                  <input type="checkbox" name="skills[]" value="1" />
                  <div class="box">
                    <span>Backend Development</span>
                  </div>
                </label>
              </div>

              <div class="d-flex flex-column align-items-end">
                <button
                  class="
                    btn btn-green
                    text-uppercase
                    font-weight-bold
                    text-light
                  "
                >
                  next
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="step-four" class="d-none">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="register">
            <form>
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
                <img
                  id="profileImagePreview"
                  class="rounded-circle mt-3"
                  src="{{ asset('images/default-profile-image.png')}}"
                  style="width: 200px; height: 200px"
                />
                <input accept="image/*" type="file" id="profileImage" hidden />
                <label class="h4 font-weight-light my-5" for="profileImage">
                  Click here to upload an image
                </label>

                <button
                  class="
                    btn btn-green
                    text-uppercase
                    font-weight-bold
                    text-light
                  "
                >
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
    $(document).ready(function () {
      // Registration Step Checking.
      let step = "{{ $step }}";
      if (step === "step-one") {
        $("body").addClass("bg-register");
        $("#step-one").removeClass("d-none");
      } else if (step === "step-two") {
        $("#step-two").removeClass("d-none");
      } else if (step === "step-three") {
        $("#step-three").removeClass("d-none");
      } else if (step === "step-four") {
        $("#step-four").removeClass("d-none");
      }

      // Max Skills Validation.
      let max_skills = 5;
      $("input[type=checkbox]").click(function () {
        let n = $(".select-skills input:checked").length;
        if (n > max_skills) {
          $(this).prop("checked", false);
          alert("Max of 5");
        }
      });

      // Profile Image Preview.
      profileImage.onchange = (evt) => {
        const [file] = profileImage.files;
        if (file) {
          profileImagePreview.src = URL.createObjectURL(file);
        }
      };

      $("#step_one_form").on("submit", function (e) {
        e.preventDefault();
      });

      $(document).on("click", "#step_one_form #submit", function () {
        let name = $("#step_one_form #name");
        let surname = $("#step_one_form #surname");
        let biography = $("#step_one_form #biography");
        let email = $("#step_one_form #email");
        let password = $("#step_one_form #password");

        $.ajax({
          url: "/register",
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
          success: function (data) {
            console.log(data);
          },
          error: function (xhr, status, error) {
            $.each(xhr.responseJSON.data.messages, function (key, value) {
              console.log(value[0]);
            });
          },
        });
      });
    });
  </script>
</body>
@endsection
