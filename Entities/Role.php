<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abilities',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Auth\Database\factories\RoleFactory::new();
    }
}
