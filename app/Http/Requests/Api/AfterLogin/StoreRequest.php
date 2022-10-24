<?php

namespace App\Http\Requests\Api\AfterLogin;

use App\Models\Transaction\Absensi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lokasi_kerja' => ['required', 'string', Rule::in(array_keys(Absensi::LOKASI_KERJA))],
            'surat_tugas' => [Rule::requiredIf($this->lokasi_kerja === '4'), 'file', 'mimes:pdf,docx,jpg,jpeg', 'max:512'],
            'suhu' => ['required', 'numeric', 'integer'],
            'gejala_harian' => ['nullable', 'array'],
            'gejala_harian.*' => ['required', 'string', 'distinct', Rule::in(array_keys(Absensi::GEJALA_HARIAN))]
        ];
    }

    public function bodyParameters()
    {
        return [
            'lokasi_kerja' => [
                'description' => 'Lokasi Pekerjaan. Data from : ' . route('api.lokasi_kerja.get'),
                'example' => array_keys(Absensi::LOKASI_KERJA)[rand(1, 3)]
            ],
            'surat_tugas' => [
                'description' => 'File surat tugas. Wajib diisi jika lokasi kerja yang dipilih adalah Lapangan (4)',
            ],
            'suhu' => [
                'description' => 'Suhu tubuh',
            ],
            'gejala_harian' => [
                'description' => 'Gejala Harian',
            ],
            'gejala_harian.*' => [
                'description' => 'Data from : ' . route('api.gejala_harian.get'),
                'example' => array_keys(Absensi::GEJALA_HARIAN)[rand(1, 3)]
            ]
        ];
    }
}
