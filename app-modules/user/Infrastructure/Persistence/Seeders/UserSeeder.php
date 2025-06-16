<?php

namespace AppModules\User\Infrastructure\Persistence\Seeders;

use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserModel::factory()->count(20)->create();

    }
}
