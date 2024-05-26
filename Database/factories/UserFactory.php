<?php

namespace Modules\Auth\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Auth\Entities\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username'      => $this->faker->safeEmail(),
            'password'      => Hash::make('password'),
            'extra'         => [
                'displayName' => $this->faker->name(),
            ] ,
            'verified_at'   => $this->faker->randomElement([now(),null]),
        ];
        
    }
}

