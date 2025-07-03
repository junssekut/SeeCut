<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserRoleSeeder::class,
        ]);

        User::factory()->create([
            'username' => 'arjuna andio',
            'email' => 'arzunadio@gmail.com',
            'password' => bcrypt('anjing123'),
            'role_id' => 2,
        ]);
    }
}
