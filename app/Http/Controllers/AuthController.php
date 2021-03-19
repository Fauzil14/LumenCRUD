<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // method validate is part of BaseController class that use ProvidesConvenienceMethods trait
        $validated = $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        $user = User::create([
          'name' => $validated['name'],  
          'email' => $validated['email'],  
          'password' => Hash::make($validated['password']),  
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);

        $token = JWTAuth::attempt($validated);
        if( $token == true ) {
            $user = User::where('email', $validated['email'])->first();
            return response()->json(compact('user', 'token'));
        }
        return response()->json(['status' => 'failed', 'error' => 'Password is invalid'], 422);
    }

}
