<?php

namespace AppModules\Category\Application\UseCases;

use AppModules\Product\Domain\Services\ProductService;

class ProductsInCategory
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id): ?array
    {
        return $this->productService->products($id);
    }
}
