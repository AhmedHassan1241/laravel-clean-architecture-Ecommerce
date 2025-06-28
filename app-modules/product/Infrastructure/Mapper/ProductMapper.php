<?php

namespace AppModules\Product\Infrastructure\Mapper;


use AppModules\Category\Infrastructure\Mapper\CategoryMapper;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;

class ProductMapper
{
    public static function mapToDomain(ProductModel $productModel): Product
    {
        return new Product(
            id: $productModel->id,
            name: $productModel->formatted_name, // ucfirst()-> make first letter Capital letter
            slug: $productModel->slug,
            description: $productModel->description,
            price: $productModel->price,
            stock: $productModel->stock,
            sku: $productModel->sku,
            is_active: $productModel->is_active,
            is_featured: $productModel->is_featured,
            image: $productModel->getImageUrl(),
            categories: $productModel->categories ? ($productModel->categories->map(fn($categoryModel) => CategoryMapper::mapToDomain($categoryModel))->toArray()) : []
        );
    }


}
