<?php

namespace AppModules\Product\Infrastructure\Persistence\Seeders;

use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ProductModel::factory()->count(20)->create();

    }
}
