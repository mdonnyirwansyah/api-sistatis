<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required',
            'time' => 'required',
            'location' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'tanggal',
            'time' => 'jam',
            'location' => 'lokasi'
        ];
    }
}
