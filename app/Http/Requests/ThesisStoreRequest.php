<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThesisStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student.nim' => 'required|string',
            'student.name' => 'required|string',
            'student.phone' => 'required|string',
            'student.thesis.register_date' => 'required|date_format:Y-m-d',
            'student.thesis.title' => 'required|string',
            'student.thesis.field_id' => 'required|numeric',
            'student.thesis.semester' => 'required|string',
            'student.thesis.supervisors' => 'required|array|min:2|max:2',
            'student.thesis.supervisors.*.lecturer_id' => 'required|distinct|numeric',
            'student.thesis.supervisors.*.status' => 'required|distinct|string'
        ];
    }

    public function attributes()
    {
        return [
            'student.nim' => 'nim mahasiswa',
            'student.name' => 'nama mahasiswa',
            'student.phone' => 'no. hp mahasiswa',
            'student.thesis.register_date' => 'tanggal daftar tugas akhir',
            'student.thesis.title' => 'judul tugas akhir',
            'student.thesis.field_id' => 'kbk tugas akhir',
            'student.thesis.semester' => 'semester',
            'student.thesis.supervisors' => 'pembimbing tugas akhir',
            'student.thesis.supervisors.*.lecturer_id' => 'pembimbing tugas akhir',
            'student.thesis.supervisors.*.status' => 'status pembimbing tugas akhir'
        ];
    }
}
