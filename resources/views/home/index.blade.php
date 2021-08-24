@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'Login')

@section('body')

    <body class="bg-home">

        @include('components.navbar-lite')

        <div class="container-fluid">
            <div class="row mx-5 mt-5">
                <div class="col-xl-4 position-fixed p-0">
                    <h6 class="font-weight-bold">In what field can you be amazing?</h6>
                    <div class="row">
                        <div class="col-md-8 col-10">
                            <div class="project-filter">
                                <label>
                                    <input type="radio" name="project-filter" value="0" checked />
                                    <div class="box">
                                        <span>All</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="2" />
                                    <div class="box">
                                        <span>Marketing</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="1" />
                                    <div class="box">
                                        <span>Frontend Development</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="0" />
                                    <div class="box">
                                        <span>Backend Development</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="3" />
                                    <div class="box">
                                        <span>Data Science</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="4" />
                                    <div class="box">
                                        <span>Design</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="5" />
                                    <div class="box">
                                        <span>QA</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="project-filter" value="6" />
                                    <div class="box">
                                        <span>UX/UI</span>
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img class="card-img-top rounded-circle" src="{{ Auth::user()->image }}"
                                                    style="width: 100px; height: 100px; margin-top: -80px" />
                                                <h6 class="card-title font-weight-bold m-0 mt-2">
                                                    Filip Arsovski
                                                </h6>
                                                <p class="fs-10 font-weight-bold text-orange mt-1">
                                                    I'am a Backend Developer
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="card-title font-weight-bold m-0">
                                                        Name of project
                                                    </h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="float-right" style="margin-top: -60px">
                                                        <div class="green-circle">
                                                            <div class="text-center fs-24 mt-2">10</div>
                                                            <div class="text-center fs-11">Applicants</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="fs-11 mt-3">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                                        elit. Laudantium dolorem quibusdam earum perferendis
                                                        iste, quae magnam nostrum qui ut neque iusto dolores
                                                        laboriosam adipisci tempore pariatur illo expedita
                                                        doloribus dolorum? Lorem ipsum dolor sit amet
                                                        consectetur adipisicing elit. Magnam obcaecati
                                                        quidem necessitatibus?
                                                    </p>
                                                    <div class="text-orange">
                                                        <a href="" class="fs-11 float-right mb-3">show more</a>
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
                                            <div class="d-flex justify-content-center text-center">
                                                <div class="half-green-circle">
                                                    <p class="text-light font-weight-bold fs-8 mt-2">
                                                        Marketer
                                                    </p>
                                                </div>
                                                <div class="half-green-circle">
                                                    <p class="text-light font-weight-bold fs-8 mt-2">
                                                        Designer
                                                    </p>
                                                </div>
                                                <div class="half-green-circle">
                                                    <p class="text-light font-weight-bold fs-8 mt-2">
                                                        Frontend dev
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-4">
                                            <button class="btn btn-project-green text-uppercase float-right">
                                                i'm in
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <br />
        <br />
        <h1>{{ Session::get('access_token') }}</h1>
    </body>
@endsection
