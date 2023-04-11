<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student.nim' => 'required|string',
            'student.semester' => 'required|string',
            'student.seminar.register_date' => 'required|date_format:Y-m-d',
            'student.seminar.type' => 'required|string',
            'student.seminar.examiners' => 'required|array|min:3|max:4',
            'student.seminar.examiners.*.lecturer_id' => 'required|distinct|numeric',
            'student.seminar.examiners.*.status' => 'required|distinct|string'
        ];
    }

    public function attributes()
    {
        return [
            'student.nim' => 'nim mahasiswa',
            'student.semester' => 'semester mahasiswa',
            'student.seminar.type' => 'jenis seminar',
            'student.seminar.register_date' => 'tanggal daftar seminar',
            'student.seminar.examiners' => 'penguji seminar',
            'student.seminar.examiners.*.lecturer_id' => 'penguji seminar',
            'student.seminar.examiners.*.status' => 'status penguji seminar'
        ];
    }
}
