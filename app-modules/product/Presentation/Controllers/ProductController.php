<?php

namespace AppModules\Product\Presentation\Controllers;

use AppModules\product\Application\DTOs\CreateProductDTO;
use AppModules\product\Application\DTOs\UpdateProductDTO;
use AppModules\product\Application\UseCases\CreateProductUseCase;
use AppModules\product\Application\UseCases\DeleteProductUseCase;
use AppModules\Product\Application\UseCases\FilterProductUseCase;
use AppModules\Product\Application\UseCases\IndexAdminProductUseCase;
use AppModules\product\Application\UseCases\IndexProductUseCase;
use AppModules\Product\Application\UseCases\PermanentDeleteProductUseCase;
use AppModules\product\Application\UseCases\SearchActiveProductUseCase;
use AppModules\product\Application\UseCases\ShowProductUseCase;
use AppModules\Product\Application\UseCases\UndoDeleteUseCase;
use AppModules\product\Application\UseCases\UpdateProductUseCase;
use AppModules\product\Presentation\Requests\CreateProductRequest;
use AppModules\Product\Presentation\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    //
    public function __construct(
        private CreateProductUseCase          $createProductUseCase,
        private IndexProductUseCase           $indexProductUseCase,
        private ShowProductUseCase            $showProductUseCase,
        private UpdateProductUseCase          $updateProductUseCase,
        private DeleteProductUseCase          $deleteProductUseCase,
        private SearchActiveProductUseCase    $searchActiveProductUseCase,
        private UndoDeleteUseCase             $undoDeleteUseCase,
        private PermanentDeleteProductUseCase $permanentDeleteProductUseCase,
        private IndexAdminProductUseCase      $indexAdminProductUseCase,
        private FilterProductUseCase          $filterProductUseCase

    )
    {

    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        $productDTO = new CreateProductDTO($data['id'] ?? null, $data['name'], $data['slug'], $data['description'] ?? null, $data['price'], $data['stock'], $data['sku'], $data['is_active']);

        $product = $this->createProductUseCase->execute($productDTO);

        if (!$product) {
            return response()->json(['message' => 'Product Created Failed !']);
        }
        return response()->json(['message:' => 'Product Created Successfully', 'Product :' => $product], 201);

    }

    public function index(): JsonResponse
    {
        $products = $this->indexProductUseCase->execute();
        if (!$products) {
            return response()->json(['message' => 'No Products Found'], 403);
        }
        return response()->json(['Products' => $products]);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->showProductUseCase->execute($id);
        if (!$product) {
            return response()->json(['message' => "This Product Not Found"], 404);
        }
        return response()->json(['Product :' => $product], 200);
    }

    public function update(int $id, UpdateProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $productDTO = new UpdateProductDTO($data['id'] ?? null, $data['name'] ?? null, $data['slug'] ?? null, $data['description'] ?? null, $data['price'] ?? null, $data['stock'] ?? null, $data['sku'] ?? null, $data['is_active'] ?? null);

        $updatedProduct = $this->updateProductUseCase->execute($id, $productDTO);
        if (!$updatedProduct) {
            return response()->json(['message' => 'This Product Not Found'], 404);
        }
        return response()->json(['message' => "Product Updated Successfully", 'Product' => $updatedProduct], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleteProduct = $this->deleteProductUseCase->execute($id);

        if (!$deleteProduct) {
            return response()->json(['message' => 'Product Not Found '], 404);

        }
        return response()->json(['message' => 'Product Deleted Successfully'], 200);
    }

    public function indexAdmin(): JsonResponse
    {
        $products = $this->indexAdminProductUseCase->execute();
        if (!$products) {
            return response()->json(['message' => 'No Products Found'], 403);
        }
        return response()->json(['Products' => $products]);
    }

    public function permanentDelete(int $id): JsonResponse
    {
        $deleteProduct = $this->permanentDeleteProductUseCase->execute($id);

        if (!$deleteProduct) {
            return response()->json(['message' => 'Product Not Found '], 404);

        }
        return response()->json(['message' => 'Product Deleted Permanent Successfully'], 200);

    }

    public function undoDelete(int $id): JsonResponse
    {
        $restoreProduct = $this->undoDeleteUseCase->execute($id);
        if (!$restoreProduct) {
            return response()->json(['message' => 'Product Not Found '], 404);

        }
        return response()->json(['message' => 'Product Restored Successfully'], 200);

    }

    public function search(Request $request): JsonResponse
    {

        $query = $request->query('q');
        if (!$query) {
            return response()->json(['message' => 'Search term is required.'], 400);
        }
        $products = $this->searchActiveProductUseCase->execute($query);
        if (!$products) {
            return response()->json(['message' => 'Item Not Found.'], 400);

        }
        return response()->json(['Product' => $products]);
    }

    public function filter(Request $request): JsonResponse
    {

        if (!$request->query->count()) {
            return response()->json(['message' => 'Filter term is required.'], 400);
        }
        $products = $this->filterProductUseCase->execute($request);
        if (!$products) {
            return response()->json(['message' => 'Item Not Found.'], 400);

        }
        return response()->json(['Product' => $products]);
    }

}
