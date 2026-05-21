<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pharmacien;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        if ($request->has('email')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Login incorrect'], 401);
            }

            $token = $user->createToken('auth')->plainTextToken;

            return response()->json([
                'role' => 'user',
                'user' => $user,
                'token' => $token
            ]);
        }

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        $pharmacien = Pharmacien::where('name', $request->name)
            ->where('phone_number', $request->phone_number)
            ->first();

        if (!$pharmacien) {
            return response()->json(['message' => 'Pharmacien introuvable'], 401);
        }

        $user = $pharmacien->user;
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'role' => 'pharmacien',
            'user' => $user,
            'pharmacien' => $pharmacien,
            'token' => $token
        ]);
    }
}