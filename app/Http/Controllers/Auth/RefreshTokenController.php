<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\traits\LoginUser;
use App\Http\Controllers\Controller;
use Facades\App\Services\CacheRedisJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenController extends Controller
{
    use LoginUser;
    
    public function refresh(Request $request)
    {
        if (!JWTAuth::getToken())
            return response()->json(['jwt-auth' => 'Token not provided'] , Response::HTTP_UNAUTHORIZED);

        try {
            $newToken = auth()->refresh(true , true);
            $user = auth()->setToken($newToken)->user();

            // this added because the refresh method doesn't change iat claim to now
            // and uses previous iat of original token
            $token = JWTAuth::fromUser($user, $user->getJWTCustomClaims());
            auth()->invalidate($newToken);
        } catch (JWTException $e) {
            // TODO: chane auth response
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }

        // return response()->json(['access_token' => $newToken]);
        return $this->respondWithToken([$token , $user]);
    }
}
