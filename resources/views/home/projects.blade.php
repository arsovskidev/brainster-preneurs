@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
@endsection

@section('title', 'Login')

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
                        <a href="create-project.html" class="text-decoration-none">
                            <img src="/icons/1.png" alt="" style="width: 35px; height: 35px" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mx-5">
                <div class="col-md-8 offset-md-2">
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
                                                consectetur adipisicing elit. Magnam obcaecati quidem
                                                necessitatibus?
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
                                <div class="col-md-8 mt-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 my-auto">
                    <div class="d-flex flex-column">
                        <a href="#">
                            <img src="/icons/8.png" alt="" style="width: 23px; height: 23px" class="mb-3" />
                        </a>
                        <a href="#">
                            <img src="/icons/7.png" alt="" style="width: 25px; height: 25px" /></a>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <br />
        <br />
        <br />
    </body>
@endsection
