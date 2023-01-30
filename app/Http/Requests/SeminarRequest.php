<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'register_date' => 'required',
            'examiner_1' => 'required',
            'examiner_2' => 'required',
            'examiner_3' => 'required',
            'semester' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'register_date' => 'tanggal daftar',
            'examiner_1' => 'penguji 1',
            'examiner_2' => 'penguji 2',
            'examiner_3' => 'penguji 3',
            'semester' => 'semester',
        ];
    }
}
