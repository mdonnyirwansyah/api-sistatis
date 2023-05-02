<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->request->get('seminar')['status'] !== '0') {
            return [
                'seminar.register_date' => 'required|date_format:Y-m-d',
                'seminar.status' => 'required|numeric',
                'seminar.semester' => 'required|string',
                'seminar.date' => 'required|date_format:Y-m-d',
                'seminar.time' => 'required|date_format:H:i:s',
                'seminar.location_id' => 'required|numeric',
                'seminar.examiners' => 'required|array|min:3|max:4',
                'seminar.examiners.*.lecturer_id' => 'required|distinct|numeric',
                'seminar.examiners.*.status' => 'required|distinct|string'
            ];
        } else {
            return [
                'seminar.register_date' => 'required|date_format:Y-m-d',
                'seminar.status' => 'required|numeric',
                'seminar.semester' => 'required|string',
                'seminar.examiners' => 'required|array|min:3|max:4',
                'seminar.examiners.*.lecturer_id' => 'required|distinct|numeric',
                'seminar.examiners.*.status' => 'required|distinct|string'
            ];
        }
    }

    public function attributes()
    {
        return [
            'seminar.register_date' => 'tanggal daftar seminar',
            'seminar.status' => 'status seminar',
            'seminar.semester' => 'semester seminar',
            'seminar.date' => 'tanggal seminar',
            'seminar.time' => 'jam seminar',
            'seminar.location_id' => 'lokasi seminar',
            'seminar.examiners' => 'penguji seminar',
            'seminar.examiners.*.lecturer_id' => 'penguji seminar',
            'seminar.examiners.*.status' => 'status penguji seminar'
        ];
    }
}
