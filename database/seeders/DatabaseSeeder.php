<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AgamaSeeder::class,
            PendidikanSeeder::class,
            StatusPerkawinanSeeder::class,
            StatusKependudukanSeeder::class,
            PekerjaanSeeder::class,
            ShieldSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
