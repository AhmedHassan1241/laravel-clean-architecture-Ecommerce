<?php

namespace AppModules\product\Application\UseCases;


use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Services\ProductService;

class CreateProductUseCase
{
    public function __construct(private ProductService $productService)
    {

    }

    public function execute(CreateProductDTO $createProductDTO): ?Product
    {
        return $this->productService->store($createProductDTO);
    }

}
