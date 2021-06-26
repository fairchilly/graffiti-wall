<?php

namespace App\Services;

use Exception;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    /**
     * Creates new registered user.
     * @param  RegisterRequest  $request
     * @return User
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
        ]);

        return $user;
    }

    /**
     * Validates to check if a user exists, or if the passwords match.
     * @param  LoginRequest  $request
     * @return User|null
     */
    public function validate(LoginRequest $request)
    {
        // Check if user exists
        $user = User::where('username', $request['username'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return null;
        }

        return $user;
    }
}
