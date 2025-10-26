<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login API with user type parameter
     * 
     * @param Request $request
     * @param string $userType
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, string $userType)
    {
        // Validate user type
        $validUserTypes = ['admin', 'customer', 'deliveryman', 'supplier'];
        if (!in_array($userType, $validUserTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid user type. Valid types are: ' . implode(', ', $validUserTypes)
            ], 400);
        }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find user by email and user type
        $user = User::where('email', $request->email)
                   ->where('user_type', $userType)
                   ->where('is_active', true)
                   ->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials for ' . $userType . ' user type'
            ], 401);
        }

        // Create token with appropriate guard
        $guardName = $userType . '-api';
        $tokenResult = $user->createToken('API Token', ['*']);
        $token = $tokenResult->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                    'phone' => $user->phone,
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
                'guard' => $guardName,
            ]
        ], 200);
    }

    /**
     * Logout API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    /**
     * Get authenticated user info
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        $user = $request->user();
        
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => $user->user_type,
                        'phone' => $user->phone,
                        'email_verified_at' => $user->email_verified_at,
                        'phone_verified_at' => $user->phone_verified_at,
                        'is_active' => $user->is_active,
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }
}
