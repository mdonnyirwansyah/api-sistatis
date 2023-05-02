<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\AccountService;

class AccountController extends Controller
{
    public function profileUpdate(ProfileUpdateRequest $request)
    {
        return AccountService::profileUpdate($request);
    }

    public function passwordUpdate(PasswordUpdateRequest $request)
    {
        return AccountService::passwordUpdate($request);
    }
}
