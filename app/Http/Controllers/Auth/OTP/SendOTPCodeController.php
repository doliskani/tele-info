<?php

namespace App\Http\Controllers\V1\Auth\OTP;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Jobs\EmailSenderQueue;
use App\Jobs\SMSSenderQueue;
use App\Models\User;
use App\Traits\Auth\LoginUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SendOTPCodeController extends Controller
{
    use LoginUser;

    public function sendCode(Request $request)
    {
        $this->validateCode($request);
        $credential = $this->getCredentials($request);
        $user_and_code = $this->createAndAddCode($credential['credential']);
        return $this->send($credential, $user_and_code);
    }

    
    private function validateCode(Request $request)
    {
        $this->validate($request, [
            'credential' =>  [
                "required",
                function ($attribute, $value, $fail) {
                    return ($this->isEmail($value) || $this->isMobile($value))
                        || $fail("the credential is invalid");
                },
            ],
        ]);
    }


    private function getCredentials(Request $request)
    {
        return $request->only(['credential',"detection_code"]);
    }


    public function createAndAddCode($credential)
    {
        $key = $this->getCredentialKey($credential);
        $code = mt_rand(1000, 9999);
        $user = User::firstOrCreate([$key => $credential], ["role" => "user"]);
        $user->addCode($code,$key);
        return [$user, $code];
    }


    public function send($credential, array $user_and_code)
    {
        [$user, $code] = $user_and_code;
        if ($this->getCredentialKey($credential["credential"]) == "mobile"){
            $detection_code = isset($credential["detection_code"]) ? $credential["detection_code"] . "\n" : "";
            dispatch(new SMSSenderQueue($user, $detection_code . Constant::CODE_MSG . $code))
                ->onQueue('sms')->onConnection("sync");
        }
        else if ($this->getCredentialKey($credential["credential"]) == "email")
            dispatch(new EmailSenderQueue($user, Constant::CODE_MSG . $code))
                ->onQueue('email')->onConnection("sync");
        return response()->json(['message' => 'کد احراز هویت ارسال شد']);
    }
}
