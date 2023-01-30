<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThesisRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nim' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'register_date' => 'required',
            'title' => 'required',
            'field' => 'required',
            'supervisor_1' => 'required',
            'supervisor_2' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'name',
            'phone' => 'no. hp',
            'register_date' => 'tanggal daftar',
            'title' => 'judul',
            'field' => 'kbk',
            'supervisor_1' => 'pembimbing 1',
            'supervisor_2' => 'pembimbing 2'
        ];
    }
}
