<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Project;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApplicationResource;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function profile()
    {
        $profile = Auth::user();
        $skills = Skill::get();
        return view('home.profile', compact('profile', 'skills'));
    }

    public function profile_show($id)
    {
        $profile = User::findOrFail($id);
        return view('home.profile_show', compact('profile'));
    }

    public function projects()
    {
        return view('home.projects');
    }

    public function project_show($id)
    {
        $project = Project::find($id);

        if ($project === null) {
            return redirect()->route('projects')->with("error", "Project don't exist.");
        }
        if ($project->user_id != Auth::user()->id) {
            return redirect()->route('projects')->with("error", "This is not your project, how do you want to see it?");
        }

        $applications = $project->applications;

        return view('home.project_show', compact('project', 'applications'));
    }

    public function project_create()
    {
        return view('home.project_create');
    }

    public function project_edit($id)
    {
        $project = Project::find($id);

        if ($project === null) {
            return redirect()->route('projects')->with("error", "Project don't exist.");
        }
        if ($project->user_id != Auth::user()->id) {
            return redirect()->route('projects')->with("error", "This is not your project, how do you want to edit it?");
        }

        $academies = Academy::get();
        return view('home.project_edit', compact('project', 'academies'));
    }

    public function applications()
    {
        return view('home.applications');
    }
}
