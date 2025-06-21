<?php

namespace AppModules\product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class IndexProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(): ?array
    {
        return $this->productService->index();
    }

}
