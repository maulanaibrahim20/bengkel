<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Technician;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PSpell\Config;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            CmsSeeder::class,
            BrandEngineSeeder::class,
            ProductCategorySeeder::class,
            ProductUnitSeeder::class,
            TechnicianSeeder::class,
            ProductSeeder::class,
            BookingSlotSeeder::class,
            ServiceSeeder::class,
            ConfigSeeder::class,
        ]);
    }
}
