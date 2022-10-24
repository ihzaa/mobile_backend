<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction\Absensi;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Support\Facades\Hash;

class AbsensiRepository
{
    public function createByRequest($validated)
    {
        $hasBeenAbsence = $this->getAbsensiUserHariIni();
        if ($hasBeenAbsence) {
            throw new Error("Anda telah mengisi form after login!", 400);
        }
        try {
            $data = Absensi::create([
                'lokasi_kerja' => $validated['lokasi_kerja'],
                'surat_tugas' => $validated['surat_tugas'] ?? NULL,
                'suhu' => $validated['suhu'],
                'gejala_harian' => $validated['gejala_harian'] ?? NULL,
                'user_id' => auth()->user()->id
            ]);
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getAbsensiUserHariIni()
    {
        $data = Absensi::where('user_id', auth()->user()->id)->first();
        return $data;
    }

    public function clock_in($validated)
    {
        $hasBeenAbsence = $this->getAbsensiUserHariIni();
        if ($hasBeenAbsence) {
            $hasBeenAbsence->clock_in = $validated;
            $hasBeenAbsence->save();
            return $hasBeenAbsence;
        } else {
            throw new Error("Anda belum mengisi form after login!", 404);
        }
    }

    public function clock_out($validated)
    {
        $hasBeenAbsence = $this->getAbsensiUserHariIni();
        if ($hasBeenAbsence) {
            if ($hasBeenAbsence->clock_in) {
                $hasBeenAbsence->clock_out = $validated;
                $hasBeenAbsence->save();
                return $hasBeenAbsence;
            } else {
                throw new Error("Anda belum melakukan clock in!", 400);
            }
        } else {
            throw new Error("Anda belum mengisi form after login!", 404);
        }
    }
}
