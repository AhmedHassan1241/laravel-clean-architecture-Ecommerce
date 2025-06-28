<?php

namespace AppModules\Product\Domain\Repositories;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function store(CreateProductDTO $createProductDTO): ?Product;

    public function index(): ?array;

    public function show(int $id): ?Product;

    public function update(int $id, UpdateProductDTO $updateProductDTO): ?Product;

    public function destroy(int $id): bool;

    public function undoDelete(int $id): bool;

    public function permanentDelete(int $id): bool;

    public function indexAdmin(): ?array;

    public function search(string $query): ?array;

    public function filter(Request $request): ?array;

    public function products(int $id): ?array;


    public function featured(): ?array;

}
