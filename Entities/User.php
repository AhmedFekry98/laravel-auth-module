<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Psy\CodeCleaner\AssignThisVariablePass;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'username',
        'password',
        // 'verified_at', // ! this private table column.
        'extra',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'    => 'hashed',
        'verified_at' => 'datetime',
        'extra'       => 'array'
    ];

    public function  getIsVerifiedAttribute(): bool
    {
        return $this->verified_at
            ? true
            :  false;
    }

    protected static function newFactory()
    {
        return \Modules\Auth\Database\factories\UserFactory::new();
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles',  'role_id');
    }

    public function abilitiesFor(string $roleName): array
    {
        $role = $this->roles()
            ->where('name', $roleName)
            ->first();

        return !$role
            ? []
            : $role->abilities;
    }
}
