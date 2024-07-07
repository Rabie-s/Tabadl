<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * Fetch all admins.
     *
     * @return JsonResponse
     */
    public function fetchAdmins(): JsonResponse
    {
        try {
            // Retrieve all admins
            $admins = Admin::latest()->paginate(8);
            return response()->json($admins, 200);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['error' => 'Failed to fetch admins.'], 500);
        }
    }

    /**
     * Authenticate admin.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Validate login request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate admin using provided credentials
        if (Auth::guard('admin')->attempt($credentials)) {
            // Retrieve authenticated admin
            $admin = auth()->guard('admin')->user();

            // Delete existing tokens to refresh authentication
            $admin->tokens()->delete();

            // Create new API token for admin
            $token = $admin->createToken('apiToken', ['role:admin']);

            // Return admin data and token on successful login
            return response()->json([
                'admin' => $admin,
                'adminToken' => $token->plainTextToken,
            ], 200);
        }

        // Return error response if authentication fails
        return response()->json(["The provided credentials do not match our records."], 401);
    }

    /**
     * Register a new admin.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validate registration request
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create API token for new admin
        $token = $admin->createToken('apiToken', ['role:admin']);

        // Login newly registered admin
        Auth::guard('admin')->login($admin);

        // Return admin data and token on successful registration
        return response()->json([
            'admin' => $admin,
            'adminToken' => $token->plainTextToken,
        ], 200);
    }

    /**
     * Delete an admin.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function deleteAdmin(string $id): JsonResponse
    {
        try {
            // Find admin by ID and delete
            $admin = Admin::findOrFail($id);
            $admin->delete();
            
            // Return success message upon successful deletion
            return response()->json(['message' => 'Admin deleted successfully'], 200);
        } catch (\Exception $e) {
            // response if admin is not found or deletion fails
            return response()->json(['error' => 'Admin not found or could not be deleted.'], 404);
        }
    }

    /**
     * Logout admin.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Delete all tokens associated with authenticated admin
        $request->user()->tokens()->delete();
        
        // Logout admin
        Auth::guard("admin")->logout();
        
        // Return success message upon successful logout
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
