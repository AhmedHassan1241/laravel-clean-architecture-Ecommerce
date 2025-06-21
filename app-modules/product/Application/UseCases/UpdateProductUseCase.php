<?php

namespace AppModules\product\Application\UseCases;


use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Services\ProductService;

class UpdateProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(int $id, UpdateProductDTO $updateProductDTO): ?Product
    {
        return $this->productService->update($id, $updateProductDTO);
    }

}
