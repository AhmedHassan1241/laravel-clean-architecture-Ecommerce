<?php

namespace AppModules\Product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class PermanentDeleteProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id)
    {
        return $this->productService->permanentDelete($id);
    }


}
