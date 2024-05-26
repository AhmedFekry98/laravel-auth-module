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

        $roles = [
            'user',
            'admin',
            'member',
        ];


        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role,
                'abilities' => json_encode(array_keys(config('system.permisions'))),
            ]);
        }

        User::factory()
            ->create([
                'username' => 'admin@gfc.com',
            ])
            ->assignRole('admin');

        User::factory(50)
            ->create()
            ->map(
                fn ($user) => $user->assignRole('user')
            );
    }
}
