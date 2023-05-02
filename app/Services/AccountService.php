<?php
namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class AccountService
{
    public static function profileUpdate($request)
    {
        $account = auth()->user();

        try {
            $account->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $response = [
                'data'=> new UserResource($account),
                'code'=> 200,
                'status'=> 'OK',
                'message' => 'Data berhasil diubah!'
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'data' => [],
                'code' => 500,
                'status' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];

            return response()->json($response, 500);
        }
    }

    public static function passwordUpdate($request)
    {
        $account = auth()->user();

        try {
            $account->forceFill([
                'password' => Hash::make($request->new_password)
            ])->save();

            return response()->json(['ok' => 'Data berhasil diubah!']);
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()]);
        }
    }
}
