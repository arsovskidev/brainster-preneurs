<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Traits\ImageUpload;
use App\Models\Academy;
use App\Models\User;

class AjaxController extends ResponseController
{
    use ImageUpload;

    public function post_login(Request $request)
    {
        $input = $request->all();

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        if (Auth::attempt($input)) {
            /** @var \App\Models\User */
            $user = Auth::user();
            Session::put('access_token', $user->createToken('access_token')->plainTextToken);

            return $this->sendResponse("success", ['message' => 'Logged in.'], 200);
        }

        return $this->sendResponse("error", ['message' => 'Invalid credentials.'], 400);
    }

    public function post_register_step_one(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'biography' => 'required|min:100|max:1000',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:64',
        ];

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        Auth::login($user);
        Session::put('access_token', $user->createToken('access_token')->plainTextToken);

        return $this->sendResponse("success", ['message' => 'Account successfully created, you can now continue setting up your profile.'], 200);
    }

    public function post_register_step_two(Request $request)
    {
        $input = $request->all();

        $rules = [
            'academy' => 'required|integer',
        ];
        $messages = [
            'academy.required' => 'Please select the academy you are in.',
            'academy.integer' => 'Please select valid academy.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        $academy = Academy::find($request->academy);

        if ($academy === null) {
            return $this->sendResponse("error", ['message' => 'Please select valid academy.'], 400);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->academy) {
            return $this->sendResponse("error", ['message' => 'You have already selected academy. Please reload webpage.'], 400);
        }

        $user->academy_id = $academy->id;
        $user->save();

        return $this->sendResponse("success", ['message' => 'Academy successfully selected.'], 200);
    }

    public function post_register_step_three(Request $request)
    {
        $input = $request->all();

        $rules = [
            'skills' => 'required|min:5|max:10',
        ];
        $messages = [
            'skills.required' => 'Please choose what skills you have.',
            'skills.min' => 'Please choose at least 5 :attribute.',
            'skills.max' => 'You can\' choose more than 10 :attribute.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->skills()->exists()) {
            return $this->sendResponse("error", ['message' => 'You have already selected skills. Please reload webpage.'], 400);
        }

        foreach ($request->skills as $skill) {
            $user->skills()->attach($skill);
        }

        return $this->sendResponse("success", ['message' => 'Skills successfully selected.'], 200);
    }

    public function post_register_step_four(Request $request)
    {
        $input = $request->all();

        $rules = [
            'image' => 'required|image',
        ];
        $messages = [
            'image.required' => 'Please upload profile image.',
            'image.image' => 'Profile image must be image type.',
        ];

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return $this->sendResponse("error", ['message' => $validation->errors()->first()], 400);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->image) {
            return $this->sendResponse("error", ['message' => 'You have already uploaded profile image.'], 400);
        }

        $image = $this->ImageUpload($request->image);
        $user->image = $image;
        $user->save();

        return $this->sendResponse("success", ['message' => 'Profile image successfully uploaded.'], 200);
    }
}
