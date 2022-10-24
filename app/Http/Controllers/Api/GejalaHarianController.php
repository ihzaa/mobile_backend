<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction\Absensi;
use Illuminate\Http\Request;

/**
 * @group Gejala Harian
 *
 * Endpoint gejala harian
 */
class GejalaHarianController extends Controller
{
    /**
     * Get Gejala Harian
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     * 
     */
    public function index()
    {
        return response()->json(
            ['data' => Absensi::LOKASI_KERJA]
        );
    }
}
