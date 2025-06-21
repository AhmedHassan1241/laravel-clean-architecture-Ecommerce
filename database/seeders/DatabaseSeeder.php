<?php

namespace Database\Seeders;

use AppModules\Category\Infrastructure\Persistence\Seeders\CategorySeeder;
use AppModules\Product\Infrastructure\Persistence\Seeders\ProductSeeder;
use AppModules\User\Infrastructure\Persistence\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

//        $this->call([\AppModules\User\Database\Seeders\DatabaseSeeder::class, \AppModules\Product\database\seeders\DatabaseSeeder::class]);
        $this->call([
            ProductSeeder::class,
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
            CategorySeeder::class
        ]);
    }
}
