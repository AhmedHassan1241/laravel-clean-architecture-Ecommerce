<?php

namespace AppModules\Product\Application\UseCases;


use AppModules\Product\Domain\Services\ProductService;
use Illuminate\Http\Request;

class FilterProductUseCase
{

    public function __construct(private ProductService $productService)
    {

    }

    public function execute(Request $request): ?array
    {
//        dd($request);
        return $this->productService->filter($request);
    }

}
