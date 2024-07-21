<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class UserAuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $token = $user->createToken('apiToken', ['role:user']);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 200);
    }

    /**
     * Log in a user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->authenticate();

            $user = $request->user();

            // Revoke all existing tokens for the user
            $user->tokens()->delete();

            // Create a new token for the user
            $token = $user->createToken('apiToken', ['role:user']);

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
            ], 200);
        }

        return response()->json(["message" => "The provided credentials do not match our records."], 401);
    }

    /**
     * Log out the authenticated user.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        // Invalidate the session
        $request->session()->invalidate();

        // Log out from the web guard
        Auth::guard("web")->logout();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
