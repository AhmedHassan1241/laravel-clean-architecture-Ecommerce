<?php

namespace AppModules\product\Infrastructure\Persistence\Repositories;

use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;
use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Domain\Entities\Product;
use AppModules\Product\Domain\Repositories\ProductRepositoryInterface;
use AppModules\Product\Infrastructure\Mapper\ProductMapper;
use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function store(CreateProductDTO $createProductDTO): ?Product
    {
//        dd($createProductDTO);

        $product = new Product(
            id: 0,
            name: $createProductDTO->getName(),
            slug: $createProductDTO->getSlug(),
            description: $createProductDTO->getDescription(),
            price: $createProductDTO->getPrice(),
            stock: $createProductDTO->getStock(),
            sku: $createProductDTO->getSku(),
            is_active: $createProductDTO->isActive(),
            is_featured: $createProductDTO->isFeatured(),
            images: $createProductDTO->getImages(),
            categories: $createProductDTO->getCategories()
        );

        $productModel = new ProductModel();

        $productModel->fill([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'slug' => $product->getSlug(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'sku' => $product->getSku(),
            'is_active' => $product->isActive(),
            'is_featured' => $product->isFeatured(),
        ]);
        $productModel->save();
        if ($product->getCategories()) {
            $productModel->categories()->sync($product->getCategories());
        }

        foreach ($product->getImages() as $imagePath) {
            $productModel->images()->create(['image_path' => $imagePath]);
        }
        Cache::forget('products_list');
        return ProductMapper::mapToDomain($productModel->fresh(['categories', 'images']));


    }


    public function update(int $id, UpdateProductDTO $updateProductDTO): ?Product
    {
        $productModel = ProductModel::with('categories')->find($id);
        $newName = $updateProductDTO->getName();
        $newSlug = $updateProductDTO->getSlug();
        if (!$productModel) {
            return null;
        }


        $productModel->update([
            'name' => $newName ?? $productModel->name,
            'slug' => $newSlug ? $newSlug : ($newName ? Str::slug($newName) : ($newSlug ?? $productModel->slug)),
            'description' => $updateProductDTO->getDescription() ?? $productModel->description,
            'price' => $updateProductDTO->getPrice() ?? $productModel->price,
            'stock' => $updateProductDTO->getStock() ?? $productModel->stock,
            'sku' => $updateProductDTO->getSku() ?? $productModel->sku,
            'is_active' => $updateProductDTO->getIsActive() ?? $productModel->is_active,
            'is_featured' => $updateProductDTO->getIsFeatured() ?? $productModel->is_featured,
        ]);
        if ($updateProductDTO->getCategories()) {
            $productModel->categories()->sync($updateProductDTO->getCategories());
        }
        if ($updateProductDTO->getImages()) {
            if ($productModel->images) {
                foreach ($productModel->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->image_path);
                    $oldImage->delete();
                }
            }

            $imagesFiles = $updateProductDTO->getImages();
            foreach ($imagesFiles as $file) {
                $extension = $file->getClientOriginalExtension();
                $path = $file->storeAs('products', $newSlug ?? $productModel->slug . "_" . uniqid() . "." . $extension, 'public');
                $productModel->images()->create(['image_path' => $path]);
            }
        }

//        dd($productModel);
//        $productModel->load('categories');
//        return ProductMapper::mapToDomain($productModel);
//or
        Cache::forget('products_list');
        Cache::forget("product_{$productModel->id}");
        return ProductMapper::mapToDomain($productModel->fresh('categories', 'images'));

    }

    public function index(): ?array
    {
//        $products = ProductModel::all(); //all active products بيستدعي booted -> addGlobalScope
//        $products = ProductModel::withoutGlobalScope('active')->get(); //all products with active + unactive
//        $products = ProductModel::priceBetween(10, 50)->get(); // range  price of products , active
//        $products = ProductModel::hasStock(90)->get();  // get stock>=90 , active
        $products = Cache::remember('products_list', 300, fn() => ProductModel::with('categories')->get()); //cache
//        $products = ProductModel::with('categories')->get();
        return $products ? ($products->map(fn($productModel) => ProductMapper::mapToDomain($productModel))->toArray()) : null;
    }

    public function indexAdmin(): ?array
    {
        $products = ProductModel::withTrashed()->get();
//        dd($products);

        return $products ? ($products->map(fn($productModel) => ProductMapper::mapToDomain($productModel))->toArray()) : null;
    }


    public function destroy(int $id): bool
    {
        $product = ProductModel::find($id);
        if (!$product) {
            return false;
        }
        Cache::forget('products_list');
        Cache::forget("product_{$product->id}");

//        dd($product->image);
//        if ($product->image) {
//            Storage::disk('public')->delete($product->image);
//        }
        return $product->delete();
    }

    public function permanentDelete(int $id): bool
    {
        $productToDelete = ProductModel::withTrashed()->find($id);
        Cache::forget('products_list');
        Cache::forget("product_{$productToDelete->id}");

//        dd($productToDelete->image);
        if ($productToDelete->main_image) {
            Storage::disk('public')->delete($productToDelete->main_image);
        }

        return $productToDelete ? $productToDelete->forceDelete() : false;
    }

    public function show(int $id): ?Product
    {
//        $productModule = ProductModel::with('categories')->find($id);
        $productModule = Cache::remember("product_{$id}", 300, fn() => ProductModel::with('categories')->find($id));
//        dd($productModule);
        if (!$productModule) {
            return null;
        }
        return ProductMapper::mapToDomain($productModule);

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
        return $products->map(fn($productModel) => ProductMapper::mapToDomain($productModel))->toArray();
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

        return $products ? ($products->map(fn($productModel) => ProductMapper::mapToDomain($productModel))->toArray()) : null;
    }

    public function products(int $id): ?array
    {
//        dd($id);
        $categoryProducts = CategoryModel::with('products')->find($id);
//        dd($categoryProducts);
        if (!$categoryProducts) {
            return null;
        }
        return $categoryProducts->products->map(fn($productModel) => ProductMapper::mapToDomain($productModel))->toArray();
    }

    public function featured(): ?array
    {
        $productsFeatured = ProductModel::featured()->get();
        if (!$productsFeatured) {
            return null;
        }
        return $productsFeatured->map(fn($product) => ProductMapper::mapToDomain($product))->toArray();
    }

}
