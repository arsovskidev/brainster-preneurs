<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Http\Resources\ProjectResource;

class ProjectController extends ResponseController
{
    public function index()
    {
        $projects = Project::orderBy("created_at", "desc")
            ->where('status', 'pending')
            ->get();

        if ($projects->isEmpty()) {
            return $this->sendResponse("error", "There are no available projects.", 404);
        }

        return $this->sendResponse('success', ProjectResource::collection($projects), 200);
    }
}
