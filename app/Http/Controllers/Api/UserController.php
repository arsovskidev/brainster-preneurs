<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends ResponseController
{
    use ImageUpload;

    public function edit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'biography' => 'required|min:100|max:1000',
            'skills' => 'required|min:5|max:10',
            'image' => 'image',
        ];
        $messages = [
            'skills.required' => 'Please choose what skills you have.',
            'skills.min' => 'Please choose at least 5 :attribute.',
            'skills.max' => 'You can\' choose more than 10 :attribute.',
            'image.image' => 'Profile image must be image type.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->biography = $request->biography;

        // Skills update.
        $user->skills()->detach();
        foreach ($request->skills as $skill) {
            $user->skills()->attach($skill);
        }

        // Image update.
        if ($request->image) {
            $image = $this->ImageUpload($request->image);
            // Delete old image.
            if ($user->image) {
                $image_path = public_path() . $user->image;
                unlink($image_path);
            }
            $user->image = $image;
        }

        $user->save();

        return $this->sendResponse('success', ["message" => "Successfully updated profile."], 200);
    }
}
