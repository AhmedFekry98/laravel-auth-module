<?php


namespace  Modules\Auth\Services;

use Graphicode\Standard\TDO\TDO;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;

class ProfileServices
{
    public static $model = User::class;

    # to get All user
    public function getAll()
    {
        $profiles = self::$model::all();
        return $profiles;
    }

    # to get user profile
    public function getOne()
    {
        try{
            $profile = Auth::user(); // ! user most be given as an external parameter.
            return $profile;
        }catch(\Throwable $e){
            return $e;
        }

    }

    # update user profile
    public function update(TDO $tdo)
    {
        try{
            $user = Auth::user(); // ! user most be given as an external prameter
            $profile = $user->update($tdo->all());
            return $this->getOne();
        }catch(\Throwable $e){
            return $e;
        }

    }


    
}