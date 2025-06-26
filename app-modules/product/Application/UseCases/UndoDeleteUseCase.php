<?php

namespace AppModules\Product\Application\UseCases;

use AppModules\Product\Domain\Services\ProductService;

class UndoDeleteUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id)
    {
        return $this->productService->undoDelete($id);

    }

}
