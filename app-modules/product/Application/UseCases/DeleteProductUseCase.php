<?php

namespace AppModules\product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class DeleteProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id): bool
    {
        return $this->productService->destroy($id);
    }

}
