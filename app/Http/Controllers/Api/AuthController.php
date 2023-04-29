<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $creditentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $creditentials['remember'] ?? false;
        unset($creditentials['remember']);
        if (!Auth::attempt($creditentials, $remember)) {
            return response([
                'message' => 'Email or Password is incorrect'
            ], 422);
        }
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have admin permission to access'
            ], 403);
        }
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->currentAccessToken();
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token->delete();
        return response('', 204);
    }
}
