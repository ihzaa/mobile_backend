<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Repositories\Master\UserRepository;
use Exception;

/**
 * @group Registration
 *
 */
class RegisterController extends Controller
{
    protected $user_repository;
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Register user
     *
     * API for register a user.
     *
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        try {
            $result = $this->user_repository->createByRequest($validated);
            return response()->json(['message' => 'User Successfully Created'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
