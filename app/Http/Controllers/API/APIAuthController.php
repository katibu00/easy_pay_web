<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIAuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and save the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

  
    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $field = filter_var($request->input('email_or_phone'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
        $credentials = [
            $field => $request->input('email_or_phone'),
            'password' => $request->input('password'),
        ];
    
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
    
            // Revoke existing tokens
            $user->tokens->each->delete();
    
            // Generate a new token
            $token = $user->createToken('AuthToken')->plainTextToken;

            $userData = [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
            ];
    
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'access_token' => $token,
                'user' => $userData,
            ], 200);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

}
