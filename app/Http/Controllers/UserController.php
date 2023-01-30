<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'email' => $request->email,
            'name' => $request->name
        ]);

        $response = [
            'code'=> '200',
            'status'=> 'OK'
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
