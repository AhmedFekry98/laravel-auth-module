<?php

namespace Modules\Auth\Services;

use Graphicode\Standard\TDO\TDO;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\OtpPassword;
use Modules\Auth\Entities\User;

class ResetPasswordService 
{
    
    private static $model = OtpPassword::class;
    private static $modelUser = User::class;
    private static $expirdToken  = 'expird' ;
    private static $getBy = 'email';

    public function resetPassword(TDO $tdo)
    {
        try{
            $token = $tdo->token;
            $OtpPassword = self::$model::where('token',$token)
                                    ->where('expire_at','>',now())
                                    ->first();
            if(!$OtpPassword)
            {
                return $this->expirdToken;
            }
            $user = self::$modelUser::where($this->getBy, $OtpPassword[$this->getBy])->first();
            // update password
            $user->password = Hash::make($tdo->password);
            $user->save();
            
            return true;

        }catch(\Throwable $e){
            return $e;
        }
    }





}