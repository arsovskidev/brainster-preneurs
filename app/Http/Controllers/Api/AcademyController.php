<?php

namespace App\Http\Controllers\Api;

use App\Models\Academy;
use App\Http\Resources\AcademyResource;

class AcademyController extends ResponseController
{
    public function index()
    {
        $academies = Academy::get();

        if ($academies->isEmpty()) {
            return $this->sendResponse("error", ["message" => "There are no available academies."], 404);
        }

        return $this->sendResponse('success', AcademyResource::collection($academies), 200);
    }
}
