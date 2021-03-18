<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $jwt;
    
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function register(Request $request)
    {
        // method validate is part of BaseController class that use ProvidesConvenienceMethods trait
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required',
        ]);

        $user = User::create([
          'name' => $request->name,  
          'email' => $request->email,  
          'password' => Hash::make($request->password),  
        ]);

        $token = $this->jwt->fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    //
}
