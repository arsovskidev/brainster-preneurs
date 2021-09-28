<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends ResponseController
{
    public function account_applications()
    {
        $applications = Auth::user()->applications;

        if ($applications->isEmpty()) {
            return $this->sendResponse("error", ["message" => "You have not applied for any project."], 404);
        }

        return $this->sendResponse('success', ApplicationResource::collection($applications), 200);
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
            return $this->sendResponse("error", ['message' => "Invalid project or already started."], 404);
        }

        // Check if user is the owner of the project.
        if (Auth::user()->id === $project->user->id) {
            return $this->sendResponse("error", ['message' => "This is your project, i know that you will work on it..."], 400);
        }

        // Check if the user requested to join the project.
        foreach (ApplicationResource::collection($project->applications) as $user) {
            if (Auth::user()->id === $user->id) {
                return $this->sendResponse("error", ['message' => "Already applied for this project..."], 400);
            }
        }

        $project->applications()->attach(Auth::user(), ['message' => $request->message]);

        return $this->sendResponse("success", ['message' => "Successfully applied to work for this project."], 200);
    }

    public function cancel($id)
    {
        $project = Project::where('id', $id)
            ->first();

        if ($project === null) {
            return $this->sendResponse("error", "Invalid project.", 404);
        }

        // Check if the user requested to join the project.
        foreach ($project->applications as $applicant) {
            if (Auth::user()->id === $applicant->id) {
                if ($applicant->pivot->status === 'accepted') {
                    return $this->sendResponse("error", ["message" => "Can't cancel a project that have accepted you."], 404);
                }
                $project->applications()->detach(Auth::user());

                return $this->sendResponse("success", ["message" => "Successfully canceled to work for this project."], 200);
            }
        }

        return $this->sendResponse("error", ["message" => "It appears that you don't have application for this project."], 400);
    }

    public function accept($project_id, $applicant_id)
    {
        $project = Project::find($project_id);

        if ($project === null) {
            return $this->sendResponse("error", ["message" => "Invalid project."], 404);
        }

        if ($project == 'started') {
            return $this->sendResponse("error", ["message" => "Project team already assembled."], 404);
        }

        // Check if user is the owner of the project.
        if (Auth::user()->id != $project->user->id) {
            return $this->sendResponse("error", ["message" => "Don't have access for this project."], 400);
        }

        // Check if the applicant requested to join the project.
        foreach ($project->applications as $applicant) {
            if ($applicant_id == $applicant->id) {
                if ($applicant->pivot->status === "accepted") {
                    return $this->sendResponse("error", ["message" => "Already accepted applicant."], 400);
                }
                $t_message = $applicant->pivot->message;
                $project->applications()->detach($applicant_id);
                $project->applications()->attach($applicant_id, ['message' => $t_message, 'status' => 'accepted']);
                return $this->sendResponse("success", ["message" => "Successfully accepted applicant."], 200);
            }
        }
        return $this->sendResponse("error", ["message" => "It appears that this applicant have not requested to work on this project."], 400);
    }
}
