<?php

namespace AppModules\Product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class FeaturedProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(): ?array
    {
        return $this->productService->featured();
    }

}
