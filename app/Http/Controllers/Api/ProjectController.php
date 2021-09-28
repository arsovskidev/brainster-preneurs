<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends ResponseController
{
    public function index()
    {
        $projects = Project::orderBy("created_at", "desc")
            ->where('status', 'pending')
            ->paginate(8);

        if ($projects->isEmpty()) {
            return $this->sendResponse("error", ["message" => "There are no available projects."], 404);
        }

        return ProjectResource::collection($projects);
    }

    public function filter($id)
    {
        $projects = Project::whereHas('academies', function ($query) use ($id) {
            return $query->where(['status' => 'pending', 'academy_id' => $id]);
        })->paginate(8);

        if ($projects->isEmpty()) {
            return $this->sendResponse("error", ['message' => "There are no available projects for this academy."], 404);
        }

        return ProjectResource::collection($projects);
    }

    public function account_projects()
    {
        $projects = Project::orderBy("created_at", "desc")
            ->where('user_id', Auth::user()->id)
            ->get();

        if ($projects->isEmpty()) {
            return $this->sendResponse("error", ['message' => "You don't have any projects."], 404);
        }

        return ProjectResource::collection($projects);
    }

    public function create(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required|max:255',
            'description' => 'required|min:250|max:1000',
            'academies' => 'required|min:1|max:4',
        ];
        $messages = [
            'academies.required' => 'Please choose what people you need.',
            'academies.min' => 'Please choose at least 1 :attribute.',
            'academies.max' => 'You can\' choose more than 4 :attribute.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        $project = new Project();
        $project->user_id = Auth::user()->id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        foreach ($request->academies as $academy) {
            $project->academies()->attach($academy);
        }

        return $this->sendResponse("success", ['message' => 'Project successfully created!'], 200);
    }

    public function edit(Request $request, $id)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required|max:255',
            'description' => 'required|min:250|max:1000',
            'academies' => 'required|min:1|max:4',
        ];
        $messages = [
            'academies.required' => 'Please choose what people you need.',
            'academies.min' => 'Please choose at least 1 :attribute.',
            'academies.max' => 'You can\' choose more than 4 :attribute.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        $project = Project::find($id);

        if ($project === null) {
            return $this->sendResponse("error", ["message" => "Invalid project."], 404);
        }

        // Check if user is the owner of the project.
        if (Auth::user()->id != $project->user->id) {
            return $this->sendResponse("error", ["message" => "Don't have access for this project."], 400);
        }

        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        $project->academies()->detach();

        foreach ($request->academies as $academy) {
            $project->academies()->attach($academy);
        }

        return $this->sendResponse("success", ['message' => 'Project successfully edited!'], 200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if ($project === null) {
            return $this->sendResponse("error", ["message" => "Invalid project."], 404);
        }

        if ($project->user_id != Auth::user()->id) {
            return $this->sendResponse("error", ["message" => "You don't have access for this project."], 404);
        }

        $project->delete();

        return $this->sendResponse("success", "Successfully removed project.", 200);
    }

    public function start($id)
    {
        $project = Project::find($id);

        if ($project === null) {
            return $this->sendResponse("error", ["message" => "Invalid project."], 404);
        }

        if ($project->status === 'started') {
            return $this->sendResponse("error", ["message" => "Project team already assembled."], 404);
        }

        // Check if user is the owner of the project.
        if (Auth::user()->id != $project->user->id) {
            return $this->sendResponse("error", ["message" => "Don't have access for this project."], 400);
        }

        $total_working = 0;
        foreach ($project->applications as $applicant) {
            if ($applicant->pivot->status === "accepted") {
                $total_working++;
            }
        }

        if ($total_working === 0) {
            return $this->sendResponse("error", ["message" => "Project must have at least 1 applicant accepted before starting."], 400);
        }

        foreach ($project->applications as $applicant) {
            if ($applicant->pivot->status === "pending") {
                $t_message = $applicant->pivot->message;
                $project->applications()->detach($applicant->id);
                $project->applications()->attach($applicant->id, ['message' => $t_message, 'status' => 'denied']);
            }
        }

        $project->status = "started";
        $project->save();
        return $this->sendResponse("success", ["message" => "Team assembled with " . $total_working . " applicants, good luck!"], 200);
    }
}
