<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            $user->remember_token = $token;
            $user->save();
    

        

            return response()->json(['status' => 'success', 'token' => $token], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete(); // Revoke the current token

            $request->user()->remember_token = null;
            $request->user()->save();
            return response()->json(['status' => 'success', 'message' => 'Logged out'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'No user authenticated'], 403);
    }
}
