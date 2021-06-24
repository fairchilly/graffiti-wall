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
     * @return Response
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

    /**
     * Registers a new user.
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        // Validate the passed fields
        $validated_fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if user exists
        $user = User::where('username', $validated_fields['username'])->first();

        // User doesn't exist, or the password don't match
        if (!$user || !Hash::check($validated_fields['password'], $user->password)) {

            // Pass unauthorized status code
            return response(['Incorrect credentials'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        // Return response with created status code
        return response($response, 201);
    }

    /**
     * Registers a new user.
     * @param  Request  $request
     * @return void
     */
    public function logout(Request $request)
    {
        // Remove the user token stored in the database
        auth()->user()->tokens()->delete();

        // Return void with a no content status code
        return response(null, 204);
    }
}
