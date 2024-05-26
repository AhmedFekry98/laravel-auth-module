<?php

namespace Modules\Auth\Services;

use App\Core\ServiceTDOFactory;
use Graphicode\Standard\TDO\TDO;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;

class RegisterService
{
    private static $model = User::class;
    const INVALID_CREDENTIAL =  'invalid_credential';

    public function register(TDO $tdo)
    {

        try {
            $username = $tdo->username;
            $password = Hash::make($tdo->password);

            // ather fields.
            $extra    =  collect($tdo->all())
                ->except(['username', 'password'])
                ->toArray();

            $data = [
                'username'    => $username,
                'password'    => $password,
                'extra'       => $extra
            ];

            $user = self::$model::create($data);
            $user->assignRole('admin');
            return $user;
        } catch (\Throwable $e) {
            // dd($e::class);
            return $e;
        }
    }
}
