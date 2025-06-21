<?php

namespace AppModules\Product\Domain\Repositories;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function store(CreateProductDTO $createProductDTO): ?Product;

    public function index(): ?array;

    public function show(int $id): ?Product;

    public function update(int $id, UpdateProductDTO $updateProductDTO): ?Product;

    public function destroy(int $id): bool;

    public function search(string $query): ?array;


}
