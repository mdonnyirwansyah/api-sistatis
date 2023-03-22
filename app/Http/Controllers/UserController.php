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
            'data' => $user,
            'code' => '200',
            'status' => 'OK',
            'message' => 'Data berhasil diubah'
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
