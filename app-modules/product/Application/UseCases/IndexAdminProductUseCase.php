<?php

namespace AppModules\Product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class IndexAdminProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute()
    {
        return $this->productService->indexAdmin();

    }
}
