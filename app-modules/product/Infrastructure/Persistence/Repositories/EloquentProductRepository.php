<?php

namespace AppModules\product\Infrastructure\Persistence\Repositories;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Repositories\ProductRepositoryInterface;
use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Support\Str;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function store(CreateProductDTO $createProductDTO): ?Product
    {
        $product = new Product(
            id: 0,
            name: $createProductDTO->getName(),
            slug: $createProductDTO->getSlug(),
            description: $createProductDTO->getDescription(),
            price: $createProductDTO->getPrice(),
            stock: $createProductDTO->getStock(),
            sku: $createProductDTO->getSku(),
            is_active: $createProductDTO->isActive()
        );

        $productModel = new ProductModel();

        $productModel->id = $product->getId();
        $productModel->name = $product->getName();
        $productModel->slug = $product->getSlug();
        $productModel->description = $product->getDescription();
        $productModel->price = $product->getPrice();
        $productModel->stock = $product->getStock();
        $productModel->sku = $product->getSku();
        $productModel->is_active = $product->isActive();
        $productModel->save();
        return $this->mapToDomain($productModel);


    }

    public function mapToDomain(ProductModel $productModel): Product
    {
        return new Product(
            id: $productModel->id,
            name: $productModel->formatted_name, // ucfirst()-> make first letter Capital letter
            slug: $productModel->slug,
            description: $productModel->description,
            price: $productModel->price,
            stock: $productModel->stock,
            sku: $productModel->sku,
            is_active: $productModel->is_active,
        );
    }

    public function index(): ?array
    {
        $products = ProductModel::all(); //all active products
//        $products = ProductModel::withoutGlobalScope('active')->get(); //all products with an active

//        $products = ProductModel::priceBetween(10, 50)->get(); // range  price of products
        if (!$products) {
            return null;
        }
        return $products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray();
    }

    public function update(int $id, UpdateProductDTO $updateProductDTO): ?Product
    {
        $productModel = ProductModel::find($id);
        if (!$productModel) {
            return null;
        }

        $newName = $updateProductDTO->getName();
        $newSlug = $updateProductDTO->getSlug();
        $productModel->update([
            'name' => $newName ?? $productModel->name,
            'slug' => $newSlug ? $newSlug : ($newName ? Str::slug($newName) : ($newSlug ?? $productModel->slug)),
            'description' => $updateProductDTO->getDescription() ?? $productModel->description,
            'price' => $updateProductDTO->getPrice() ?? $productModel->price,
            'stock' => $updateProductDTO->getStock() ?? $productModel->stock,
            'sku' => $updateProductDTO->getSku() ?? $productModel->sku,
            'is_active' => $updateProductDTO->getIsActive() ?? $productModel->is_active,
        ]);

        return $this->mapToDomain($productModel); // إذا كنت بترجع domain object

    }

    public function destroy(int $id): bool
    {
        $product = $this->show($id);
        if (!$product) {
            return false;
        }
        return ProductModel::destroy($id);
    }

    public function show(int $id): ?Product
    {
        $productModule = ProductModel::find($id);
        if (!$productModule) {
            return null;
        }
        return $this->mapToDomain($productModule);

    }

    public function search(string $query): ?array
    {
//        dd($query);
        $products = ProductModel::where('is_active', true)->where(fn($q) => $q->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
        )->get();
        return $products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray();
    }
}
