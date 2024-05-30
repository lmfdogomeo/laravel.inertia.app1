<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (!Auth::attempt($request->credentials(), $request->rememberMe())) {
            return response()->json([
                'status' => 'Unauthorize',
                'message' => 'Invalid email or password'
            ]);
        }

        $user = $request->user();
        $tokenResult = $user->createToken("Personal Access Token");
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'Login successfully',
            'token_type' => 'bearer',
            'token' => $token
        ]);
    }
}
