<?php

namespace AppModules\Category\Infrastructure\Persistence\Factories;


use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryModelFactory extends Factory
{

    protected $model = CategoryModel::class;

    public function definition(): array
    {
        return [];
    }
}
