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
            'seminar.date' => 'required|date_format:Y-m-d',
            'seminar.time' => 'required|date_format:H:i',
            'seminar.location_id' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'seminar.date' => 'tanggal seminar',
            'seminar.time' => 'jam seminar',
            'seminar.location' => 'lokasi seminar',
        ];
    }
}
