<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->authenticate();

            $user = $request->user();

            $user->tokens()->delete();

            $token = $user->createToken('apiToken');

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
            ], 200);
        }
        return response()->json(["The provided credentials do not match our records."], 401);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        $request->session()->invalidate(); 
        Auth::guard("web")->logout();
        return response()->json([null, 200]);
    }
}
