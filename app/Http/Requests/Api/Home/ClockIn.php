<?php

namespace App\Http\Requests\Api\Home;

use App\Models\Transaction\Absensi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClockIn extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jam_kerja' => ['required', 'date_format:H:i:s'],
            'lokasi_kerja' => ['required', 'string', Rule::in(array_keys(Absensi::LOKASI_KERJA))],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'jam_kerja' => [
                'description' => 'Jam kerja saat melakukan clock in'
            ],
            'lokasi_kerja' => [
                'description' => 'Lokasi Pekerjaan. Data from : ' . route('api.lokasi_kerja.get'),
                'example' => array_keys(Absensi::LOKASI_KERJA)[rand(1, 3)]
            ],
            'latitude' => [
                'description' => 'Latitude saat melakukan clock in',
            ],
            'longitude' => [
                'description' => 'Longitude saat melakukan clock in',
            ],
        ];
    }
}
