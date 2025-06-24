<?php

namespace AppModules\Category\Infrastructure\Persistence\Repositories;

use AppModules\Category\Application\DTOs\StoreCategoryDTO;
use AppModules\Category\Application\DTOs\UpdateCategoryDTO;
use AppModules\Category\Domain\Entities\Category;
use AppModules\Category\Domain\Repositories\CategoryRepositoryInterface;
use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;
use Illuminate\Support\Str;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function store(StoreCategoryDTO $categoryDTO): ?Category
    {
        if (CategoryModel::where('name', $categoryDTO->getName())->orWhere('slug', $categoryDTO->getSlug() ?? Str::slug($categoryDTO->getName()))->exists()) {
            return null;
        }

        $category = new Category(
            id: null,
            name: $categoryDTO->getName(),
            slug: $categoryDTO->getSlug() ?? Str::slug($categoryDTO->getName()),
            description: $categoryDTO->getDescription(),
            is_active: $categoryDTO->getIsActive(),
            parent_id: $categoryDTO->getParentId()
        );

        $categoryModel = new CategoryModel();

        $categoryModel->fill([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'description' => $category->getDescription(),
            'is_active' => $category->getIsActive(),
            'parent_id' => $category->getParentId()
        ]);
        $categoryModel->save();

        return $this->mapToDomain($categoryModel);
    }

    public function mapToDomain(CategoryModel $categoryModel): Category
    {
        return new Category(
            id: $categoryModel->id,
            name: $categoryModel->name,
            slug: $categoryModel->slug,
            description: $categoryModel->description,
            is_active: $categoryModel->is_active,
            parent_id: $categoryModel->parent_id,

        );

    }

    public function index(): ?array
    {

        $mainCategoriesModel = CategoryModel::with('children')->where('is_active', true)->whereNull('parent_id')->get();
        return $mainCategoriesModel ? ($mainCategoriesModel->map(function ($categoryModel) {
            return ['category' => $this->mapToDomain($categoryModel),
                'children' => $categoryModel->children->map(fn($child) => $this->mapToDomain($child))->toArray()
            ];
        })->toArray()) : null;
    }

//    public function index(): ?array
//    {
//        $categoriesModel = CategoryModel::where('is_active', true)->get();
//
//
//        return $categoriesModel ? $categoriesModel->map(fn($categoryModel) => $this->mapToDomain($categoryModel))->toArray() : null;
//
//    }

    public function destroy(int $id): bool
    {
        $category = CategoryModel::find($id);
        if (!$category) {
            return false;
        }

        CategoryModel::where('parent_id', $category->id)->update(['parent_id' => $category->parent_id]);


        return $category->delete();
    }

    public function update(int $id, UpdateCategoryDTO $categoryDTO): ?Category
    {
//        dd($this->show($id));
        $categoryModel = CategoryModel::find($id);
//        $categoryModel = CategoryModel::with(['parent', 'children'])->find($id);
        if (!$categoryModel) {

            return null;
        }

        $newName = $categoryDTO->getName();
        $newSlug = $categoryDTO->getSlug();
        $categoryModel->update([
            'name' => $categoryDTO->getName() ?? $categoryModel->name,
//            'slug' => $categoryDTO->getSlug() ?? $categoryModel->slug,
            'slug' => $newSlug ?? ($newName ? Str::slug($newName) : $categoryModel->slug),
            'description' => $categoryDTO->getDescription() ?? $categoryModel->description,
            'is_active' => $categoryDTO->getIsActive() ?? $categoryModel->is_active,
            'parent_id' => $categoryDTO->getParentId() ?? $categoryModel->parent_id
        ]);

        return $this->mapToDomain($categoryModel);

    }

//    public function show(int $id): ?Category
//    {
//        $categoryModel = CategoryModel::with(['parent', 'children'])->find($id);
//        dd($categoryModel);
//
//        return $categoryModel ? $categoryModel->$this->mapToDomain($categoryModel) : null;
//
//
//    }

    public function show(int $id): ?array
    {
        $categoryModel = CategoryModel::with(['parent', 'children'])->find($id);

        return $categoryModel
            ? [
                'category' => $this->mapToDomain($categoryModel),
                'children' => $categoryModel->children->map(fn($child) => $this->mapToDomain($child))->toArray()
            ]
            : null;


    }

}
