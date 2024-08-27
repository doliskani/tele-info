<?php


namespace App\Helpers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommonService
{

    /**
     * get jwt token for first user
     *
     * @return string
     */
    public static function getUserJwtToken() : string
    {
        $user = User::first();
        $token = JWTAuth::fromUser($user, $user->getJWTCustomClaims());
        return "Bearer " . $token;
    }

}
