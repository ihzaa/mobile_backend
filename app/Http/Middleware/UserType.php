<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Utils\FlashMessageHelper;
use Closure;
use Illuminate\Http\Request;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        $user = auth()->user();
        if (User::user_type[$user->user_type] != $userType) {
            FlashMessageHelper::bootstrapDangerAlert('Tipe user anda:' . User::user_type[$user->user_type] . '. Yang dibutuhkan: ' . $userType, 'Tipe User Tidak Sesuai.');

            // Jika role user sekarang admin maka balik ke dashboard admin
            if ($user->user_type == 1)
                return redirect(route('admin.dashboard.index'));

            // Seterusnya ....
        }
        return $next($request);
    }
}
