<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeminarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
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
