<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        $cookie = \Cookie::forget('access_token');

        return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Set cookie details and return cookie
     *
     * @param string $token JWT
     *
     * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
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

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
