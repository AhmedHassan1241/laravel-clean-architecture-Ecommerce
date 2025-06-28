<?php

namespace AppModules\Product\Domain\Services;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {

    }

    public function store(CreateProductDTO $createProductDTO): ?Product
    {
        return $this->productRepository->store($createProductDTO);
    }

    public function index(): ?array
    {
        return $this->productRepository->index();
    }

    public function indexAdmin(): ?array
    {
        return $this->productRepository->indexAdmin();
    }

    public function show(int $id): ?Product
    {
        return $this->productRepository->show($id);
    }

    public function update(int $id, UpdateProductDTO $updateProductDTO): ?Product
    {
        return $this->productRepository->update($id, $updateProductDTO);
    }

    public function destroy(int $id): bool
    {
        return $this->productRepository->destroy($id);
    }

    public function undoDelete(int $id): bool
    {
        return $this->productRepository->undoDelete($id);
    }

    public function permanentDelete(int $id): bool
    {
        return $this->productRepository->permanentDelete($id);
    }

    public function search(string $query): ?array
    {
        return $this->productRepository->search($query);
    }

    public function filter(Request $request): ?array
    {
        return $this->productRepository->filter($request);
    }

    public function products(int $id): ?array
    {
        return $this->productRepository->products($id);
    }

    public function featured(): ?array
    {
        return $this->productRepository->featured();
    }
}
