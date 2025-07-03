<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        echo "Seeding 3 user roles...\n";

        $roles = ['user', 'admin', 'vendor'];

        foreach ($roles as $role) {
            UserRole::create(['role' => $role]);
        }
    }
}
