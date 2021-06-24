<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Registers a new user.
     * @param  Request  $request
     * @return Collection
     */
    public function register(Request $request)
    {
        // Validate the passed fields
        $validated_fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed',
        ]);

        // Hash the password
        $validated_fields['password'] = bcrypt($validated_fields['password']);

        // Create a new user
        $user = User::create([
            'name' => $validated_fields['password'],
            'username' => $validated_fields['username'],
            'password' => $validated_fields['password'],
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        // Return response with created status code
        return response($response, 201);
    }
}
