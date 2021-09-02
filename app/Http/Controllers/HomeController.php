<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

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

    public function project_create()
    {
        $academies = Academy::get();
        return view('home.project_create', compact('academies'));
    }

    public function project_edit($id)
    {
        $project = Project::find($id);

        if ($project === null) {
            return Redirect::to(URL::previous() . "#project-invalid");
        }
        if ($project->user_id != Auth::user()->id) {
            return Redirect::to(URL::previous() . "#project-invalid");
        }

        $academies = Academy::get();
        return view('home.project_edit', compact('project', 'academies'));
    }

    public function applications()
    {
        return view('home.applications');
    }
}
