<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'id_number' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'id_number' => $fields['id_number'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);

    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Email and Password'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);

    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Log out'
        ], 200);
    }

    public function test() {

        $user = auth()->user();

        return response([
            'user' => $user
        ], 200);
    }
}
