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
        return [
            'student.seminar.register_date' => 'required|date_format:Y-m-d',
            'student.seminar.type' => 'required|string',
            'seminar.semester' => 'required|string',
            'seminar.date' => 'required|date_format:Y-m-d',
            'seminar.time' => 'required|date_format:H:i:s',
            'seminar.location' => 'required|numeric',
            'student.seminar.examiners' => 'required|array|min:3|max:4',
            'student.seminar.examiners.*.lecturer_id' => 'required|distinct|numeric',
            'student.seminar.examiners.*.status' => 'required|distinct|string'
        ];
    }

    public function attributes()
    {
        return [
            'student.seminar.register_date' => 'tanggal daftar seminar',
            'student.seminar.type' => 'jenis seminar',
            'seminar.semester' => 'semester seminar',
            'seminar.date' => 'tanggal seminar',
            'seminar.time' => 'jam seminar',
            'seminar.location' => 'lokasi seminar',
            'student.seminar.examiners' => 'penguji seminar',
            'student.seminar.examiners.*.lecturer_id' => 'penguji seminar',
            'student.seminar.examiners.*.status' => 'status penguji seminar'
        ];
    }
}
