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
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {

            $admin = auth()->guard('admin')->user();

            $admin->tokens()->delete();

            $token = $admin->createToken('apiToken', ['role:admin']);

            return response()->json([
                'admin' => $admin,
                'adminToken' => $token->plainTextToken,
            ], 200);
        }
        return response()->json(["The provided credentials do not match our records."], 401);
    }

    public function register(Request $request): JsonResponse
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $admin->createToken('apiToken', ['role:admin']);
        Auth::guard('admin')->login($admin);

        return response()->json([
            'admin' => $admin,
            'adminToken' => $token->plainTextToken,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        Auth::guard("admin")->logout();
        return response()->json([null, 200]);
    }
}
