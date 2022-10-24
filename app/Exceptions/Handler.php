<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        if (request()->expectsJson()) {
            $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
                return response()->json([
                    'message' => 'You do not have the required permission.'
                ], 403);
            });
        }
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // API exception
        if ($request->header('ajax') == "1" || $request->expectsJson() || $request->ajax() || $request->header('Content-Type') == 'application/json') {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Record not found.',
                ], 404);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => $e->validator->messages()->first()
                ], 422);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Request Not Found'
                ], 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 405);
            }

            if ($e instanceof UnauthorizedException) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 401);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'message' => $e->getMessage(), 'subcode' => 4011
                ], 401);
            }
            $response = [
                'message' => config('app.debug') ? $e->getMessage() : 'Server Error',
            ];
            if (config('app.debug')) {
                $response['exception'] = get_class($e);
                $response['stack'] = $e->getTrace();
            }
            return response()->json($response, $e->getCode() != 0 ? $e->getCode() : 500);
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        // if ($request->expectsJson()) {
        //     return response()->json(['error' => 'Unauthenticated.'], 401);
        // }

        // return redirect('/login');
        // $guard = Arr::get($exception->guards(), 0);
        // switch ($guard) {
        //     case 'admin':
        //         // $login = route('admin.auth.login.get');
        //         $login = route('auth.login.get');
        //         break;
        //     case 'prodi':
        //         session()->flash('guard', 'prodi');
        //         $login = route('auth.login.get');
        //         break;
        //     case 'mahasiswa':
        //         $login = route('siswa.loginGet');
        //         break;
        // }

        $login = route('auth.login.get');

        return $request->expectsJson()
            ? response()->json([
                'message' => $exception->getMessage(),
            ], 401)
            : redirect()->guest($login);
    }
}
