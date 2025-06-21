<?php

namespace AppModules\product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class SearchActiveProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(string $query): ?array
    {
        return $this->productService->search($query);
    }

}
