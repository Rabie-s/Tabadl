<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    // Register a new admin
    public function register(Request $request): JsonResponse
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins', // Unique email check against admins table
            'password' => 'required'
        ]);

        // Create a new admin using validated data
        Admin::create($validated);

        try {
            // Attempt to authenticate admin with 'admin-api' guard
            $token = auth('admin-api')->attempt($validated);
            $adminInfo = auth('admin-api')->user();

            // If authentication fails, return unauthorized response
            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Return admin info and token upon successful registration
            return response()->json([
                'admin' => $adminInfo,
                'token' => $token,
            ], 200);
        } catch (JWTException $e) {
            // Catch JWT authentication exceptions and return error response
            return response()->json('Login error:' . $e, 500);
        }
    }

    // Admin login
    public function login(Request $request): JsonResponse
    {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            // Attempt to authenticate admin with 'admin-api' guard
            $token = auth('admin-api')->attempt($credentials);
            $adminInfo = auth('admin-api')->user();

            // If authentication fails, return unauthorized response
            if (!$token) {
                return response()->json(['error' => 'user name or password is incorrect'], 401);
            }

            // Return admin info and token upon successful login
            return response()->json([
                'admin' => $adminInfo,
                'adminToken' => $token,
            ], 200);
        } catch (JWTException $e) {
            // Catch JWT authentication exceptions and return error response
            return response()->json('Login error:' . $e, 500);
        }
    }

    // Get admin information
    public function adminInfo()
    {
        try {
            // Return JSON response with authenticated admin information
            return response()->json(auth('admin-api')->user());
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
                'token' => auth('admin-api')->refresh(true),
            ]);
        } catch (JWTException $e) {
            // Catch JWT authentication exceptions and return error response
            return response()->json('Error:' . $e, 500);
        }
    }

    // Logout admin
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

    // Delete admin profile
    public function deleteAdminProfile(string $id)
    {
        try {
            // Find admin by ID and delete
            $admin = Admin::findOrFail($id);
            $admin->delete();
            return response()->json(['message' => 'Admin deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // Catch model not found exceptions and return error response
            return response()->json(['error' => 'Admin not found'], 404);
        }
    }
}
