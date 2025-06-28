<?php

namespace AppModules\Category\Infrastructure\Mapper;


use AppModules\Category\Domain\Entities\Category;
use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;

class CategoryMapper
{
    public static function mapToDomain(CategoryModel $categoryModel): Category
    {
        return new Category(
            id: $categoryModel->id,
            name: $categoryModel->name,
            slug: $categoryModel->slug,
            description: $categoryModel->description,
            is_active: $categoryModel->is_active,
            parent_id: $categoryModel->parent_id,

        );

    }


}
