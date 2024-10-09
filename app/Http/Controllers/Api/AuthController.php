<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SigninRequest;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use JsonResponse;

    public function signin(SigninRequest $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->errorResponse('Login failed, your email is not registered',401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Login failed, your email or password is incorrect. Please try again',401);
        }

        $auth['access_token'] = Auth::login($user);
        return $this->successResponse($auth);
    }
}
