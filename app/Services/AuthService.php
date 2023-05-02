<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function login($credentials)
    {
        if (! $token = auth()->attempt($credentials)) {
            $response = [
                'data'=> 'Identitas tersebut tidak cocok dengan data kami.',
                'code'=> 401,
                'status'=> 'Unauthorized',
                'message' => 'Data tidak valid'
            ];
            return response()->json($response, 401);
        }

        $user = [
            'id' => auth()->user()->id,
            'role' => auth()->user()->role->name,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ];

        $authService = new Self();

        $cookie = $authService->getCookie('access_token', $token);

        $response = [
            'data'=> $authService->respondWithToken($token)->original,
            'code'=> 200,
            'status'=> 'OK',
            'message' => 'Login berhasil'
        ];

        return response()->json($response, 200)->withCookie($cookie);
    }

    public static function getMe()
    {
        return auth()->user();
    }

    public static function logout()
    {
        auth()->logout();

        $cookie = \Cookie::forget('access_token');

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
    }

    public static function refresh($authRefresh)
    {
        $authService = new Self();

        return $authService->respondWithToken($authRefresh);
    }

    private function getCookie($name, $token)
    {
        return cookie(
            $name,
            $token,
            auth()->factory()->getTTL(),
            null,
            null,
            env('APP_DEBUG') ? false : true,
            true,
            false,
            'Strict'
        );
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 240
        ]);
    }
}
