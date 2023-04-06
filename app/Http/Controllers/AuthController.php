<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $creditentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $creditentials['remember'] ?? false;
        unset($creditentials['remember']);
        if(!Auth::attempt($creditentials, $remember)) {
            return response([
                'message' => 'Email or Password is incorrect'
            ], 422);
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have admin permission to access'
            ], 403);
        }
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user'=> $user,
            'token' => $token
        ]);
    }

    public function logout() {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->currentAccessToken();
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token->delete();
        return response('', 204);
    }
}