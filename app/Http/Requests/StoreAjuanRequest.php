<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAjuanRequest extends FormRequest
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
            'suratPermintaanPembayaranSPP' => 'required|file|max:2048',
            'rab' => 'required|file|max:2048',
            'pernyataanPertanggungJawaban' => 'required|file|max:2048',
            'dpa' => 'required|file|max:2048',
            'skTimPelaksana' => 'required|file|max:2048',
            'skDasarKegiatan' => 'required|file|max:2048',
        ];
    }
}
