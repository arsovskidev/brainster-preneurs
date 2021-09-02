<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
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
            'description' => 'required|min:300|max:1000',
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
        $project->short_description = substr_replace($request->description, "...", 300);
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
            'description' => 'required|min:300|max:1000',
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

        $project->name = $request->name;
        $project->description = $request->description;
        $project->short_description = substr_replace($request->description, "...", 300);
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
    public function apply(Request $request, $id)
    {
        $input = $request->all();

        $rules = [
            'message' => 'required|string|max:255',
        ];
        $messages = [
            'message.required' => 'Please write a message.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['messages' => $validation->errors()], 400);
        }

        $project = Project::where(['id' => $id, 'status' => 'pending'])
            ->first();

        if ($project === null) {
            return $this->sendResponse("error", "Invalid project or already started.", 404);
        }

        // Check if user is the owner of the project.
        if (Auth::user()->id === $project->user->id) {
            return $this->sendResponse("error", "This is your project, i know that you will work on it...", 400);
        }

        // Check if the user already requested to join the project.
        foreach (UserResource::collection($project->applications) as $user) {
            if (Auth::user()->id === $user['id']) {
                return $this->sendResponse("error", "Already applied for this project...", 400);
            }
        }

        $project->applications()->attach(Auth::user(), array('message' => $request->message));

        return $this->sendResponse("success", "Successfully applied to work for this project.", 200);
    }

    public function cancel($id)
    {
        $project = Project::where('id', $id)
            ->first();

        if ($project === null) {
            return $this->sendResponse("error", "Invalid project.", 404);
        }

        // Check if the user requested to join the project.
        foreach (UserResource::collection($project->applications) as $user) {
            if (Auth::user()->id === $user['id']) {
                $project->applications()->detach(Auth::user());

                return $this->sendResponse("success", "Successfully canceled to work for this project.", 200);
            }
        }

        return $this->sendResponse("error", "It appears that you don't have application for this project.", 400);
    }
}
