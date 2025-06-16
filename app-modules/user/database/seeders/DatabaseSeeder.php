<?php

namespace AppModules\User\Database\Seeders;

use AppModules\User\Infrastructure\Persistence\Seeders\ProfileSeeder;
use AppModules\User\Infrastructure\Persistence\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
        ]);
    }
}
