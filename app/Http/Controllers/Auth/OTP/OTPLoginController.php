<?php

namespace App\Http\Controllers\V1\Auth\OTP;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\User;
use App\Traits\Auth\LoginUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OTPLoginController extends Controller
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
            'credential' =>  ["required"],
            'code' => ["required"],
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
        return $request->only(['credential', "code"]);
    }

    /**
     * Attempt login with credentials
     * 
     * @param array $credentials
     * @return bool|\Illuminate\Http\JsonResponse
     */
    protected function attemptLogin(array $credentials)
    {
        if (isset($credentials['code']))
            return $this->validateCode($credentials);
        return false;
    }

    /**
     * Validate Code from credentials
     * 
     * @param array $credentials
     * 
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function validateCode(array $credentials)
    {
        if ($user = $this->getUser($credentials))
            $this->invalidateCode($user, $credentials['code']);

        return $user ? $this->getToken($user) : false;
    }

    /**
     * get user from credentials
     * 
     * @param array $credentials
     * 
     * @return \App\Models\User
     */
    private function getUser(array $credentials)
    {
        $key = $this->getCredentialKey($credentials["credential"]);

        return User::where($key, $credentials["credential"])
            ->whereHas('codes', function ($q) use ($credentials, $key) {
                $q->where("code", (int) $credentials["code"])
                    ->where("used", false)
                    ->where("expire", false)
                    // ->where("refrence", $key)
                    ->where("expire_time", ">", Carbon::now()->getTimestamp());
            }, '>=', 1)
            ->with(['province' , 'city'])
            ->select([
                'age' , 'gender' , 'user_type' ,
                'avatar' , 'name' , 'mobile' , 'email' ,
                'password' , 'role_ids' , 'city_id' , 'province_id'
            ])
            ->first();
    }


    private function invalidateCode($user, int $code)
    {
        return Code::where("user_id", $user->_id)
            ->where("code", $code)
            ->first()
            ->update(["used" => true]);
    }
}
