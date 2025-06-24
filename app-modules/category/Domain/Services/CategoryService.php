<?php

namespace AppModules\Category\Domain\Services;


use AppModules\Category\Application\DTOs\StoreCategoryDTO;
use AppModules\Category\Application\DTOs\UpdateCategoryDTO;
use AppModules\Category\Domain\Entities\Category;
use AppModules\Category\Domain\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {

    }

    public function store(StoreCategoryDTO $categoryDTO): ?Category
    {
        return $this->categoryRepository->store($categoryDTO);
    }

    public function update(int $id, UpdateCategoryDTO $categoryDTO): ?Category
    {
        return $this->categoryRepository->update($id, $categoryDTO);
    }

    public function show(int $id): ?array
    {
        return $this->categoryRepository->show($id);
    }


    public function index(): ?array
    {
        return $this->categoryRepository->index();
    }

    public function destroy(int $id): bool
    {
        return $this->categoryRepository->destroy($id);
    }
}
