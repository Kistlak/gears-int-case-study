<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //validate request
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        //authenticate user request
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $userRole = $user->getRoleNames()->first();
//            $userRole = $user->role()->first();

            if ($userRole) {
                $this->scope = $userRole;
            }

            $token = $user->createToken($user->email.'-'.now(), [$this->scope]);

            return response()->json([
                'token' => $token->accessToken,
                'response_code' => 1
            ],200);
        } else {
            return response()->json([
                'message' => "Invalid email or password",
                'response_code' => 0
            ],403);
        }
    }
}
