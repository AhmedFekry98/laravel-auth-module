<?php

namespace Modules\Auth\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Role;
use Modules\Auth\Entities\User;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        User::factory(50)->create();
        Role::factory(3)->create();
    }
}
