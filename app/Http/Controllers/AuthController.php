<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response = [
                'code'=> '422',
                'status'=> 'Unprocessable Content',
                'data'=> $errors
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            $response = [
                'code'=> '401',
                'status'=> 'Unauthorized',
                'data'=> ['failed' => 'Identitas tersebut tidak cocok dengan data kami.']
            ];
            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        $user = [
            'id' => auth()->user()->id,
            'role' => auth()->user()->role->name,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ];

        $cookie = $this->getCookie('access_token', $token);

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $this->respondWithToken($token)->original
        ];
        return response()->json($response, Response::HTTP_OK)->withCookie($cookie);
    }

    public function me()
    {
        $user = auth()->user();
        $data = [
            'id' => $user->id,
            'role' => $user->role->name,
            'name' => $user->name,
            'email' => $user->email
        ];

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $data
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->logout();
        $cookie = \Cookie::forget('access_token');

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
