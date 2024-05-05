<?php

namespace Modules\Auth\Services;

use Graphicode\Standard\TDO\TDO;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Modules\Auth\Enums\ErrorCode;
use Modules\Sanctum\Services\Users\UsersServiceFactory;

class LoginService
{
    private static $models = User::class;

    private $getBy  = 'username';


    public function login(TDO $tdo) // return int value only if has error code
    {

        try {
            $validated =  $tdo->all();
            $user = self::$models::where($this->getBy, $validated[$this->getBy])->first();
        } catch (\Throwable $e) {
            return $e;
        }

        if ( !$user || !Hash::check($validated['password'], $user->password)) {
            return null;
        }

        return $user;
    }
}
