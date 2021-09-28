<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    public function index()
    {
        $academies = Academy::get();
        $skills = Skill::get();
        $step = $this->step_check();

        if ($step === 'completed') {
            return redirect(RouteServiceProvider::HOME);
        }

        return view('auth.register', compact('step', 'academies', 'skills'));
    }

    public function step_check()
    {
        if (Auth::check()) {
            /** @var \App\Models\Skill */
            $user = Auth::user();
            if (!$user->academy) {
                return 'step-two';
            }
            if (!$user->skills()->exists()) {
                return 'step-three';
            }
            if (!$user->image) {
                return 'step-four';
            }
            return 'completed';
        } else {
            return 'step-one';
        }
    }
}
