<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AfterLogin\StoreRequest;
use App\Http\Requests\Api\Home\ClockIn;
use App\Http\Requests\Api\Home\ClockOut;
use App\Models\Transaction\Absensi;
use App\Repositories\Transaction\AbsensiRepository;
use Illuminate\Http\Request;

/**
 * @group Home
 *
 * Endpoint halaman home
 */
class AfterLoginController extends Controller
{

    protected $absensi_repository, $absensi;
    public function __construct(AbsensiRepository $absensi_repository, Absensi $absensi)
    {
        $this->absensi_repository = $absensi_repository;
        $this->absensi = $absensi;
    }
    /**
     * Form After Login
     *
     * Form setelah user login
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     */
    public function after_login(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->absensi_repository->createByRequest($validated);
        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'data' => [
                'user' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email
                ],
                'lokasi_kerja' => [
                    'id' => $response->lokasi_kerja,
                    'text' => $this->absensi::LOKASI_KERJA[$response->lokasi_kerja]
                ],
                'suhu' => $response->suhu
            ]
        ], 201);
    }

    /**
     * Home
     *
     * Get data setelah form after login
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     */
    public function home()
    {
        $response = $this->absensi_repository->getAbsensiUserHariIni();
        if ($response) {
            return response()->json([
                'message' => 'Data form after login hari ini ditemukan!',
                'data' => [
                    'user' => [
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email
                    ],
                    'lokasi_kerja' => [
                        'id' => $response->lokasi_kerja,
                        'text' => $this->absensi::LOKASI_KERJA[$response->lokasi_kerja]
                    ],
                    'suhu' => $response->suhu
                ]
            ], 201);
        } else {
            return response()->json([
                'message' => 'Data form after login tidak ditemukan!',
            ], 404);
        }
    }

    /**
     * Clock in
     *
     * Clock in absensi
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     */
    public function clock_in(ClockIn $request)
    {
        $validated = $request->validated();
        $response = $this->absensi_repository->clock_in($validated);

        return response()->json([
            'message' => 'Clock in berhasil!',
        ]);
    }

    /**
     * Clock out
     *
     * Clock out absensi
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     */
    public function clock_out(ClockOut $request)
    {
        $validated = $request->validated();
        $response = $this->absensi_repository->clock_out($validated);

        return response()->json([
            'message' => 'Clock out berhasil!',
        ]);
    }
}
