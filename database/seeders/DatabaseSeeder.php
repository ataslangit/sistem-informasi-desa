<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            ResidentAndFamilySeeder::class,
            LetterTemplateSeeder::class,
            LetterRequestSeeder::class,
            ContentSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
