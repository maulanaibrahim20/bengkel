<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = ['Super Admin', 'Admin', 'User'];
        foreach ($role as $r) {
            Role::create([
                'name' => $r,
            ]);
        }

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role_id' => 3,
        ]);

        $this->call([
            CmsSeeder::class,
        ]);
    }
}
