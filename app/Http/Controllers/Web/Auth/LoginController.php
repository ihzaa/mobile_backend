<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginGet()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $validation = ValidationHelper::validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::whereUsername($request->username)->orWhere('email', $request->username)->first();
        if ($user == null) {
            FlashMessageHelper::bootstrapDangerAlert(
                'Username atau password salah!'
            );
            return back();
        }
        if (!Hash::check($request->password, $user->password)) {
            FlashMessageHelper::bootstrapDangerAlert(
                'Username atau password salah!'
            );
            return back();
        }
        $remember = $request->has('remember') ? true : false;
        Auth::loginUsingId($user->id, $remember);

        $route = route('auth.login.get');
        if ($user->user_type == 1)
            $route = (route('admin.dashboard.index'));
        // seterusnya

        return redirect()->intended($route);
    }

    public function logout()
    {
        auth()->logout();

        return redirect(route('auth.login.get'));
    }
}
