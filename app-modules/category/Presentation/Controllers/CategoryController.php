<?php

namespace AppModules\Category\Presentation\Controllers;


use AppModules\Category\Application\DTOs\StoreCategoryDTO;
use AppModules\Category\Application\DTOs\UpdateCategoryDTO;
use AppModules\Category\Application\UseCases\AllCategoriesUseCase;
use AppModules\Category\Application\UseCases\DeleteCategoryUseCase;
use AppModules\Category\Application\UseCases\ShowCategoryUseCase;
use AppModules\Category\Application\UseCases\StoreCategoryUseCase;
use AppModules\Category\Application\UseCases\UpdateCategoryUseCase;
use AppModules\Category\Presentation\Requests\StoreCategoryRequest;
use AppModules\Category\Presentation\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function __construct(private StoreCategoryUseCase $storeCategoryUseCase, private ShowCategoryUseCase $showCategoryUseCase, private AllCategoriesUseCase $allCategoriesUseCase, private UpdateCategoryUseCase $updateCategoryUseCase, private DeleteCategoryUseCase $deleteCategoryUseCase)
    {

    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $categoryDTO = new StoreCategoryDTO(0, $data['name'], $data['slug'] ?? null, $data['description'] ?? null, $data['is_active'] ?? null, $data['parent_id'] ?? null);

        $category = $this->storeCategoryUseCase->execute($categoryDTO);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Name Or Slug Already Exists.'
            ], 409); // Conflict
        }
        return response()->json(['message' => 'Category Created Successfully', 'Category' => $category], 200);

    }

    public function update(int $id, UpdateCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        $categoryDTO = new UpdateCategoryDTO(null, $data['name'] ?? null, $data['slug'] ?? null, $data['description'] ?? null, $data['is_active'] ?? null, $data['parent_id'] ?? null);
        $category = $this->updateCategoryUseCase->execute($id, $categoryDTO);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found.'
            ], 404);
        }
        return response()->json(['message' => 'Category Updated Successfully', 'Category' => $category], 201);
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->showCategoryUseCase->execute($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found.'
            ], 404);
        }
        return response()->json([
            'data' => $category
        ], 200);
    }

    public function index(): JsonResponse
    {
        $categories = $this->allCategoriesUseCase->execute();
        if (!$categories) {
            return response()->json([
                'status' => false,
                'message' => 'No Category Found.'
            ], 404);
        }
        return response()->json(['data' => $categories], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $category = $this->deleteCategoryUseCase->execute($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Category Deleted Successfully.'
        ], 201);

    }
}
