<?php

namespace App\Http\Controllers\Auth\traits;

use App\Helpers\PaymentSerivce;
use App\Jobs\SaveUserLikeToCacheJob;
use App\Models\User;
use Facades\App\Services\CacheRedisJson;
use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

trait LoginUser
{

    /**
     * Login and return access token.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse 
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->getCredentials($request);
        if ($data = $this->attemptLogin($credentials))
            return $this->successfulLogin($data);
        return $this->failedLogin($credentials);
    }


    /**
     * get token from user
     * 
     * @param \App\Models\User $user
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function getToken(User $user)
    {
        return JWTAuth::fromUser($user, $user->getJWTCustomClaims());
    }

    /**
     * create and return response from token for successful login
     * 
     * @param string $token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successfulLogin($data)
    {
        return $this->respondWithToken($data);
    }

    /**
     * create response from token
     * 
     * @param string $token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        // PaymentSerivce::syncingPaymentService($user , "user" , $token);


        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'role' => JWTAuth::toUser($token)->role,
            'expires_in' => Auth::guard()->factory()->getTTL()
        ]);
    }

    /**
     * create and return response for failed login
     *  
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedLogin()
    {
        return response(['error' => 'Unauthorized'], 401);
    }

    /**
     * Check is mobile credential
     * 
     * @param  string  $string
     * @return bool
     */
    public function isMobile($string)
    {
        $iranMobileRegex = '~^09\d{9}$~';
        preg_match($iranMobileRegex, $string, $matches);
        return !empty($matches);
    }

    /**
     * Check is email credential
     * 
     * @param  string  $string
     * @return bool
     */
    public function isEmail($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }

    public function getCredentialKey($credential)
    {
        if ($this->isEmail($credential))
            return "email";
        else if ($this->isMobile($credential))
            return "mobile";
    }
}
