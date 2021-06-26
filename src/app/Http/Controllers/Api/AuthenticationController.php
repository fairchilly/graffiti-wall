<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    /**
     * The authentication service implementation.
     *
     * @var AuthenticationService
     */
    protected $authentication;

    /**
     * Create a new controller instance.
     *
     * @param  AuthenticationService  $authentication
     * @return void
     */
    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Registers a new user.
     * @param  RegisterRequest  $request
     * @return array
     */
    public function register(RegisterRequest $request)
    {
        // Username can't contain anonymous
        $contains_anonymous = strpos(strtolower($request['username']), 'anonymous');
        
        if ($contains_anonymous !== false && $contains_anonymous >= 0) {
            return response('Username cannot contain the word anonymous', 403);
        }


        // Create a new user, with a hashed password
        $user = $this->authentication->register($request);

        // Create a response object with token
        $response = $this->createTokenResponse($user);

        // Return the response with created status code
        return response($response, 201);
    }

    /**
     * Logins an existing user.
     * @param  LoginRequest  $request
     * @return array
     */
    public function login(LoginRequest $request)
    {
        // Check if user exists
        $user = $this->authentication->validate($request);

        // User doesn't exist, or the password don't match
        if (!$user) {

            // Pass unauthorized status code
            return response(['Incorrect credentials'], 401);
        }

        // Create a response object with token
        $response = $this->createTokenResponse($user);

        // Return response with created status code
        return response($response, 201);
    }

    /**
     * Logs out the authenticated user.
     * @return void
     */
    public function logout()
    {
        // Remove the user token stored in the database
        auth()->user()->tokens()->delete();

        // Return void with a no content status code
        return response(null, 204);
    }

    /**
     * Returns a token response object.
     * @param  User  $user
     * @return array
     */
    private function createTokenResponse(User $user)
    {
        // Create a new token
        $token = $user->createToken('authToken')->plainTextToken;

        // Create a response object
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $response;
    }
}
