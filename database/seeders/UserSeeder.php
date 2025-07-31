<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'username' => 'arjunaandio',
            'email' => 'arzunadio@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->profile()->updateOrCreate([], [
            'first_name' => 'Arjuna',
            'last_name' => 'Andio',
            'role' => 'customer',
            'gender' => 'male',
            'birth_date' => '1995-03-15',
        ]);

        $vendor = User::factory()->create([
            'username' => 'jelvisanggono',
            'email' => 'jelvisanggono@gmail.com',
            'password' => bcrypt('password')
        ]);

        $vendor->profile()->updateOrCreate([], [
            'first_name' => 'Jelvis',
            'last_name' => 'Anggono',
            'role' => 'vendor',
            'gender' => 'male',
            'birth_date' => '1992-08-22',
        ]);

        $vendor->vendor()->updateOrCreate([], [
            "name" => 'JA Barbershop',
            "latitude" => 1.4,
            "longitude" => 2.1,
            "place_id" => 192939124
        ]);

        $admin = User::factory()->create([
            'username' => 'matthewraditya',
            'email' => 'matthewraditya03@gmail.com',
            'password' => bcrypt('password')
        ]);

        $admin->profile()->updateOrCreate([], [
            'first_name' => 'Matthew',
            'last_name' => 'Raditya',
            'role' => 'admin',
            'gender' => 'male',
            'birth_date' => '1990-12-03',
        ]);
    }
}
