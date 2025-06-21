<?php

namespace AppModules\product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;

class ShowProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id)
    {
        return $this->productService->show($id);
    }

}
