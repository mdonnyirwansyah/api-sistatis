<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        return AuthService::login($credentials);
    }

    public function me()
    {
        $user = AuthService::getMe();

        $response = [
            'data'=> new UserResource($user),
            'code'=> 200,
            'status'=> 'OK',
            'message' => 'Data user by login'
        ];

        return response()->json($response, 200);
    }

    public function logout()
    {
        return AuthService::logout();
    }

    public function refresh()
    {
        return AuthService::refresh(auth()->refresh());
    }
}
