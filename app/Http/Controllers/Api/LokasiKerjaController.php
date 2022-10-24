<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Absensi;
use Illuminate\Http\Request;

/**
 * @group Lokasi Kerja
 *
 * Endpoint Lokasi Kerja
 */
class LokasiKerjaController extends Controller
{
    /**
     * Get Lokasi Kerja
     *
     * @authenticated
     *
     */
    public function index()
    {
        return response()->json(
            ['data' => Absensi::LOKASI_KERJA]
        );
    }
}
