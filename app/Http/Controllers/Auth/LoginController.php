<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\traits\LoginUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use LoginUser;


    /**
     * Validate Login credentials
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' =>  ["required"],
            'password' => ["required"],
        ]);
    }

    /**
     * Get credentials
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only(['email', "password"]);
    }

    /**
     * Get user from credentials and attempt and get token from user
     * 
     * @param array $credentials
     * @return bool|string
     */
    protected function attemptLogin(array $credentials)
    {
        $user = User::where("email", $credentials["email"])
                     ->first();
                     
        if ($user && Hash::check($credentials['password'], $user->password))
            if ($token = JWTAuth::fromUser($user, $user->getJWTCustomClaims()))
                return $token;
        return false;
    }

   
}


