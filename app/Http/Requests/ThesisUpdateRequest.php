<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThesisUpdateRequest extends FormRequest
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
            'student.register_date' => 'required|date_format:Y-m-d',
            'student.generation' => 'required|numeric|min:1970',
            'student.status' => 'required|numeric|between:0,1',
            'student.graduate_date' => 'nullable|date_format:Y-m-d',
            'student.gpa' => 'required|numeric|between:0,4',
            'student.thesis.register_date' => 'required|date_format:Y-m-d',
            'student.thesis.title' => 'required|string',
            'student.thesis.field_id' => 'required|numeric',
            'student.thesis.semester' => 'required|string',
            'student.thesis.finish_date' => 'nullable|date_format:Y-m-d',
            'student.thesis.status' => 'required|numeric|between:0,3',
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
            'student.register_date' => 'tanggal daftar mahasiswa',
            'student.generation' => 'angkatan',
            'student.status' => 'status mahasiswa',
            'student.graduate_date' => 'tanggal lulus mahasiswa',
            'student.gpa' => 'ipk mahasiswa',
            'student.thesis.register_date' => 'tanggal daftar tugas akhir',
            'student.thesis.title' => 'judul tugas akhir',
            'student.thesis.field_id' => 'kbk tugas akhir',
            'student.thesis.semester' => 'semester',
            'student.thesis.finish_date' => 'tanggal lulus tugas akhir',
            'student.thesis.status' => 'status tugas akhir',
            'student.thesis.supervisors' => 'pembimbing tugas akhir',
            'student.thesis.supervisors.*.lecturer_id' => 'pembimbing tugas akhir',
            'student.thesis.supervisors.*.status' => 'status pembimbing tugas akhir'
        ];
    }
}
