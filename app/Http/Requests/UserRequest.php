<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nama',
        ];
    }
}
