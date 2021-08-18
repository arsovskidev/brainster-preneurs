<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public function sendResponse($status, $data = [], $code)
    {
        $response = [
            'status' => $status,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }
}
