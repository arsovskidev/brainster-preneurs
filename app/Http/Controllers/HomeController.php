<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function profile()
    {
        return view('home.profile');
    }

    public function projects()
    {
        return view('home.projects');
    }

    public function applications()
    {
        return view('home.applications');
    }
}
