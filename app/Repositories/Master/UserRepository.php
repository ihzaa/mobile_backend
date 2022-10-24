<?php

namespace App\Repositories\Master;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createByRequest($validated)
    {
        try {
            $data = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }
}
