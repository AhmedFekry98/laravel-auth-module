<?php


namespace Modules\Auth\Services;

use Graphicode\Standard\TDO\TDO;
use Modules\Auth\Entities\OtpPassword;

class CheckOtpService
{

    private static $model = OtpPassword::class;

    public function checkOtp(TDO $tdo)
    {
        $email = $tdo->email;
        $otp =   $tdo->otp;

        $user = self::$model::where('email', $email)
            ->where('otp', $otp)
            ->where('expire_at', '>', now())
            ->where('token', '<>', null)
            ->first();
            
        if (!$user) {
            throw new \Exception('Invalid OTP');
        }

        $token = $user->token;
        return $token;
    }

  

}
