<?php

namespace AppModules\Category\Infrastructure\Persistence\Seeders;


use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{

    public function run(): void
    {

        $mainCategories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Cameras'],
            'Fashion' => ['Men Clothing', 'Women Clothing', 'Shoes'],
            'Home & Kitchen' => ['Furniture', 'Kitchen Appliances', 'Decor'],
            'Books' => ['Fiction', 'Non-fiction', 'Children Books'],
            'Sports' => ['Fitness Equipment', 'Outdoor Gear', 'Activewear'],
        ];

        foreach ($mainCategories as $main => $children) {
            $parent = CategoryModel::create([
                'name' => $main,
                'slug' => Str::slug($main),
                'description' => 'Main category: ' . $main,
                'is_active' => true,
                'parent_id' => null
            ]);

            foreach ($children as $child) {
                CategoryModel::create([
                    'name' => $child,
                    'slug' => Str::slug($child),
                    'description' => 'Subcategory under ' . $main,
                    'is_active' => true,
                    'parent_id' => $parent->id
                ]);
            }
        }


    }
}
