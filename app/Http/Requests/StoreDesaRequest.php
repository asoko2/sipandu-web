<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'kode_desa' => 'unique:desas,kode_desa|required',
            'nama_desa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_desa.required' => "Kode Desa harus diisi",
            'kode_desa.unique' => 'Kode Desa sudah ada. Silahkan pilih kode yang lain',
            'nama_desa.required' => 'Nama Desa harus diisi'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'kode_desa' => '35.22.20.' . $this->kode_desa,
        ]);
    }
}
