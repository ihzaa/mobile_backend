<?php

namespace App\Http\Controllers\Web\ForgetPassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index($token)
    {
        $data = DB::table('password_resets')->where('token', $token)->first();

        if ($data == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data reset password tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }
        return view('forget_password.reset_password', compact('data'));
    }

    public function store($token, Request $request)
    {
        $validation = ValidationHelper::validateWithoutAutoRedirect(
            $request,
            [
                'password' => [
                    'required', 'min:8', 'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                ],
            ],
            [
                'confirmed' => 'Konfirmasi :attribute tidak sama.'
            ],
            [
                'password' => 'Password',
                'password_confirmation' => 'Ulangi Password'
            ]
        );
        if ($validation->fails()) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => $validation->messages()->first()
            ]);
            return back();
        }
        $data = DB::table('password_resets')->where('token', $token)->first();
        if ($data == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data reset password tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }

        $user = User::where('email', $data->email)->first();
        if ($user == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Data User tidak ditemukan!"
            ]);
            return redirect(route('forget.password.index'));
        }

        DB::beginTransaction();
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::commit();

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Reset Password Berhasil!"
        ]);
        return redirect(route('auth.login.get'));
    }
}
