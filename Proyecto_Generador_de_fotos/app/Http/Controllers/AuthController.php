<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|ends_with:airtificial.com',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => explode('@', $request->email)[0],
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid login credentials'], 401);
            }

            $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'access_token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}