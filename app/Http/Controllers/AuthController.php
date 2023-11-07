<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Htto\Request\SignupRequest;
use App\Htto\Request\LoginRequest;
use App\Models\User;
use Illuminate\Suport\Facades\Auth;

class AuthController extends Controller
{
    public function signup (SignupRequest $request)
    {
        $data = $request->validated();

            /** @var \App\Models\User $user */
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bycrypt($data['password'])
            ]);
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ]);
    }

    public function login (LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $credentials['rememeber'] ?? false;
        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)){
            return response ([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();
        $token = $user->createToken('main')->plaintTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout (Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        //Resolve the token thar was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return repsonse([
            'succes' => true
        ]);
    }
}