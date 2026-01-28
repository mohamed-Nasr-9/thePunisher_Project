<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     try {
    //         $data = $request->validate([
    //             'name' => 'required|string',
    //             'email' => 'required|email|unique:users',
    //             'password' => 'required|min:6',
    //             'phone' => 'nullable|string',
    //         ]);

    //         $user = User::create([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'password' => Hash::make($data['password']),
    //             'role' => 'customer',
    //             'phone' => $data['phone'] ?? null,
    //         ]);

    //         $token = JWTAuth::fromUser($user);

    //         return response()->json([
    //             'message' => 'User registered successfully',
    //             'token' => $token,
    //             'user' => $user,
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Registration failed',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required',
    //         ]);

    //         if (! $token = JWTAuth::attempt($credentials)) {
    //             return response()->json([
    //                 'message' => 'Invalid credentials'
    //             ], 401);
    //         }

    //         return response()->json([
    //             'message' => 'Login successful',
    //             'token' => $token,
    //             'user' => auth('api')->user(),
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Login failed',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function me()
    // {
    //     try {
    //         $user = auth('api')->user();

    //         if (!$user) {
    //             return response()->json([
    //                 'message' => 'User not authenticated'
    //             ], 401);
    //         }

    //         return response()->json([
    //             'message' => 'User retrieved successfully',
    //             'user' => $user,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Failed to retrieve user',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function logout()
    // {
    //     try {
    //         JWTAuth::logout();

    //         return response()->json([
    //             'message' => 'Logged out successfully'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Logout failed',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }


    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            // 'role'     => 'customer',
            'phone' => $request->phone ?? null,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user'  => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'user'  => JWTAuth::user(),
        ]);
    }

    public function me()
    {
        return response()->json([
            'user' => JWTAuth::user()
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
