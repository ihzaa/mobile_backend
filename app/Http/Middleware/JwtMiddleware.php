<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use JWTAuth;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $errorSubCode = [
            '4011' => 'Authorization Token not found',
            '4012' => 'Token is Invalid',
            '4013' => 'Token is Expired'
        ];
        $token = $request->header('x-access-token');

        // refresh token validation
        // dont use refresh token as a header x-access-token
        $user = User::where('refresh_token', $token)->first();
        if ($user)
            return response()->json(['message' => 'Authorization Token not found', 'subcode' => 4011], 401);

        $request->headers->set('Authorization', 'Bearer ' . $token);
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message' => 'Token is Invalid', 'subcode' => 4012], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message' => 'Token is Expired', 'subcode' => 4013], 401);
            } else {
                return response()->json(['message' => 'Authorization Token not found', 'subcode' => 4011], 401);
            }
        }
        return $next($request);
    }
}
