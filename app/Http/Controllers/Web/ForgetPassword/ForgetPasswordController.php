<?php

namespace App\Http\Controllers\Web\ForgetPassword;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('forget_password.forget_password');
    }

    public function store(Request $request)
    {
        ValidationHelper::validate(
            $request,
            [
                'email' => 'required',
            ],
            [
                'email' => 'Format Email tidak valid.',
                'exists' => 'Email tidak ditemukan.'
            ],
            [
                'email' => 'Email',
            ]
        );

        $user = User::whereUsername($request->email)->orWhere('email', $request->email)->first();

        if ($user == null) {
            FlashMessageHelper::swal([
                "icon" => "error",
                "title" => "Gagal!",
                "text" => "Username atau Email tidak ditemukan."
            ]);
            return back();
        }

        $email = $user->email;
        $token = "";
        do {
            $token = Str::random(64);
            $counter = DB::table('password_resets')->where('token', $token)->count();
        } while ($counter != 0);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forget_password', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });

        FlashMessageHelper::swal([
            "icon" => "success",
            "title" => "Berhasil!",
            "text" => "Anda akan menerima email reset password, silahkan cek folder spam jika email tidak ditemukan pada folder inbox!"
        ]);
        return back();
    }
}
