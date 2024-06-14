<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $email    = $request->input('email');
            $password = $request->input('password');

            $user     = User::where("email", $email)->first();

            if (!$user) return response()->json([
                'message' => "User not found",
                "error"   => "NOT_FOUND"
            ], 404);

            if (!Hash::check($password, $user->password)) return response()->json([
                'message' => "Password didn't matches",
                'error'   => "FORBIDDEN"
            ], 422);


            $token    = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token, 'user' => $user, 'message' => "You're logged in"];
            return response($response, 200);
        } catch (Exception $err) {
            Log::critical($err->getMessage());
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => 'SERVER_ERROR'
            ], 500);
        }
    }
}
