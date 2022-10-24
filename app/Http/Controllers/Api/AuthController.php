<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationHelper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

/**
 * @group Auth
 *
 * APIs for auth users
 */
class AuthController extends Controller
{

    /**
     * Login user
     *
     * API for logged in a user.
     *
     *
     * @response 200 scenario="Username dan password match" {"message":"login success","access_token":"xxxxx","refresh_token":"yyyyy"}
     * @response 401 scenario="Username doesn't exist" {"message":"User tidak ditemukan!"}
     * @response 401 scenario="Username dan password not match" {"message":"Username atau password salah!"}
     * @response 500 scenario="Internal server error" {"message":"Could not create token.", "error":"some thing wrong!"}
     * @responseField message The message of the response API.
     * @responseField access_token The token that will be used in every request header to authorize the user, the `access_token` only valid for 15 minutes.
     * @responseField refresh_token The token that will be used for get new `access_token` when expired, the `refresh_token` expired in 1 month.
     *
     * @bodyParam username string required The username of the user.
     * @bodyParam password string required The password of the user.
     */
    public function login(Request $request)
    {
        ValidationHelper::validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::whereUsername($request->username)->orWhere('email', $request->username)->first();
        if ($user == null) {
            return response()->json([
                'message' => "User tidak ditemukan!"
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' =>  'Username atau password salah!'
            ], 401);
        }

        //Create token
        try {
            $token = $this->getAccessToken($user);
            // refresh token active for 4 weeks (1 month)
            $refresh_token = auth()->guard('api')->setTTL(20160 * 2)->login($user);
            $user->refresh_token = $refresh_token;
            $user->save();
            return response()->json([
                'message' => 'login success',
                'access_token' => $token,
                'refresh_token' => $user->refresh_token
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Could not create token.',
                'error' => $e
            ], 500);
        }
    }

    /**
     * Logout user
     *
     * API for loging out a user.
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     * @response 200 scenario="header x-access-token valid" {"message":"User successfully signed out"}
     *
     * @response 401 scenario="Access token is invalid" {"message":"Token is Invalid","subcode":4012}
     * @response 401 scenario="Access token is expired" {"message":"Token is Expired","subcode":4013}
     * @response 401 scenario="Access token is not found" {"message":"Authorization Token not found","subcode":4011}
     *
     * @responseField message string The message of the response API.
     * @responseField subcode integer The subcode of the response HTTP response code.
     *
     */
    public function logout()
    {
        $user = auth()->guard('api')->user();
        $user->refresh_token = NULL;
        $user->save();
        auth()->guard('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Check logged in user
     *
     * API for check logged in user.
     *
     * @authenticated
     *
     * @header x-access-token {access_token from login API}
     *
     * @response 200 scenario="header x-access-token valid" {"username":"username","name":"name","email":"email"}
     *
     * @response 401 scenario="Access token is invalid" {"message":"Token is Invalid","subcode":4012}
     * @response 401 scenario="Access token is expired" {"message":"Token is Expired","subcode":4013}
     * @response 401 scenario="Access token is not found" {"message":"Authorization Token not found","subcode":4011}
     *
     * @responseField message string The message of the response API.
     * @responseField subcode integer The subcode of the response HTTP response code.
     *
     */
    public function check()
    {
        $user = auth()->guard('api')->user();
        return response()->json([
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * Refresh Token
     *
     * Refresh access token when expired.
     *
     *
     * @response 200 scenario="refresh_token valid" {"message":"Refresh token success!","access_token":"the_token"}
     *
     * @response 401 scenario="Access token is invalid `go to login page`" {"message":"Token is Invalid","subcode":4012}
     * @response 401 scenario="Access token is expired `go to login page`" {"message":"Token is Expired","subcode":4013}
     * @response 401 scenario="Access token is not found `go to login page`" {"message":"Authorization Token not found","subcode":4011}
     *
     * @responseField message string The message of the response API.
     * @responseField subcode integer The subcode of the response HTTP response code.
     * @responseField access_token The token that will be used in every request header to authorize the user, the `access_token` only valid for 15 minutes.
     *
     * @bodyParam refresh_token string required The `refresh_token` from login API.
     */
    public function refresh(Request $request)
    {
        ValidationHelper::validate($request, [
            'refresh_token' => ['required']
        ]);

        $refresh_token = $request->refresh_token;

        $user = User::where('refresh_token', $refresh_token)->first();
        if (!$user)
            return response()->json(['message' => 'Authorization Token not found', 'subcode' => 4011], 401);

        $request->headers->set('Authorization', 'Bearer ' . $refresh_token);
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
        $token = $this->getAccessToken($user);

        return response()->json([
            'message' => 'Refresh token success!',
            'access_token' => $token,
        ]);
    }

    private function getAccessToken($user)
    {
        return auth()->guard('api')->setTTL(15)->login($user);
    }
}
