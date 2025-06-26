<?php

namespace AppModules\product\Infrastructure\Persistence\Repositories;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Repositories\ProductRepositoryInterface;
use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Http\Request;
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

//        $productModel->fill([
//        'id' => $product->getId(),
//            'name' => $product->getName(),
//            'slug' => $product->getSlug(),
//            'description' => $product->getDescription(),
//            'price' => $product->getPrice(),
//            'stock' => $product->getStock(),
//            'sku' => $product->getSku(),
//            'is_active' => $product->isActive(),
//        ]);
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
        $products = ProductModel::all(); //all active products بيستدعي booted -> addGlobalScope
//        $products = ProductModel::withoutGlobalScope('active')->get(); //all products with active + unactive
//        $products = ProductModel::priceBetween(10, 50)->get(); // range  price of products , active
//        $products = ProductModel::hasStock(90)->get();  // get stock>=90 , active

        return $products ? ($products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray()) : null;
    }

    public function indexAdmin(): ?array
    {
        $products = ProductModel::withTrashed()->get();
//        dd($products);

        return $products ? ($products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray()) : null;
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
        $product = ProductModel::find($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }

    public function permanentDelete(int $id): bool
    {
        $productToDelete = ProductModel::withTrashed()->find($id);

        return $productToDelete ? $productToDelete->forceDelete() : false;
    }

    public function show(int $id): ?Product
    {
        $productModule = ProductModel::find($id);
        if (!$productModule) {
            return null;
        }
        return $this->mapToDomain($productModule);

    }

    public function undoDelete(int $id): bool
    {
//        dd(ProductModel::onlyTrashed()->get());
//        $restoreProduct = ProductModel::withTrashed()->find($id);
        $restoreProduct = ProductModel::onlyTrashed()->find($id);

        if (!$restoreProduct || !$restoreProduct->trashed()) {
            return false;
        }

        return $restoreProduct->restore();
    }

    public function search(string $query): ?array
    {
        if (trim($query) === '') {
            return [];
        }
        $products = ProductModel::where('is_active', true)->where(fn($q) => $q->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
        )->get();
        return $products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray();
    }

    public function filter(Request $request): ?array
    {
//        dd($request);
        $products = ProductModel::query()
//            ->where('is_active', true)
            ->when($request->has('min_price'), fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->has('max_price'), fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->has('stock_min'), fn($q) => $q->where('stock', '>=', $request->stock_min))
            ->when($request->has('q'), function ($query) use ($request) {
                $query->where(fn($q) => $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('description', 'like', "%{$request->q}%")
                );

            })->get();

        return $products ? ($products->map(fn($productModel) => $this->mapToDomain($productModel))->toArray()) : null;
    }
}
