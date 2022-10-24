<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = auth()->user();

        if ($user) {
            // Jika role user sekarang admin maka balik ke dashboard admin
            if ($user->user_type == 1)
                return redirect(route('admin.dashboard.index'));
            // Seterusnya ....
        }

        return $next($request);
    }
}
