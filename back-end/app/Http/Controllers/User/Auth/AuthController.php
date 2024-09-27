<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request): JsonResponse
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required'
        ]);

        // Create a new user using validated data
        User::create($validated);

        try {
            // Attempt to authenticate user with 'user-api' guard
            $token = auth('user-api')->attempt($validated);
            $userInfo = auth('user-api')->user();

            // If authentication fails, return unauthorized response
            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'user' => $userInfo,
                'token' => $token,
            ], 200);
        } catch (JWTException $e) {
            return response()->json('Login error:' . $e, 500);
        }
    }

    // Login user
    public function login(Request $request): JsonResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            // Attempt to authenticate user with 'user-api' guard
            $token = auth('user-api')->attempt($credentials);
            $userInfo = auth('user-api')->user();

            // If authentication fails, return unauthorized response
            if (!$token) {
                return response()->json(['error' => 'user name or password is incorrect'], 401);
            }

            return response()->json([
                'user' => $userInfo,
                'token' => $token,
            ], 200);
        } catch (JWTException $e) {
            return response()->json('Login error:' . $e, 500);
        }
    }

    // Get user information
    public function userInfo()
    {
        try {
            // Return JSON response with authenticated user information
            return response()->json(auth('user-api')->user());
        } catch (JWTException $e) {
            // Catch JWT authentication exceptions and return error response
            return response()->json('Error:' . $e, 500);
        }
    }

    // Refresh JWT token
    public function refreshToken()
    {
        try {
            // Refresh JWT token and return as JSON response
            return response()->json([
                'token' => auth('user-api')->refresh(true),
            ]);
        } catch (JWTException $e) {
            // Catch JWT authentication exceptions and return error response
            return response()->json('Error:' . $e, 500);
        }
    }

    // Logout user
    public function logout(Request $request)
    {

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out'
            ],200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to log out, please try again.'
            ], 500);
        }
    }

    // Delete user profile
    public function deleteUserProfile(string $id)
    {
        try {
            // Find user by ID and delete
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Catch model not found exceptions and return error response
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
