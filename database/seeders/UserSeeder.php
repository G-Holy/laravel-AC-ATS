<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // hasMissions : Méthode magic qui assume une fonction de relation [User::missions]
        User::factory()->count(100)
            ->hasMissions(rand(1, 8), function (array $attributes, User $user) {
                return ['user_id' => $user->id];
            })
            ->create();
    }
}
