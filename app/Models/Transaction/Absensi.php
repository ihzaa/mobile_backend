<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    const LOKASI_KERJA = [
        '1' => 'Kantor Pusat',
        '2' => 'Area',
        '3' => 'Proyek',
        '4' => 'Lapangan'
    ];

    const GEJALA_HARIAN = [
        '1' => 'flu',
        '2' => 'batuk',
        '3' => 'radang',
        '4' => 'sesak'
    ];

    protected $fillable = ['lokasi_kerja', 'surat_tugas', 'suhu', 'gejala_harian', 'user_id'];

    protected $casts = [
        'gejala_harian' => 'array',
        'clock_in' => 'array',
        'clock_out' => 'array',
    ];
}
