<?php

namespace AppModules\Category\Application\UseCases;


use AppModules\Category\Application\DTOs\UpdateCategoryDTO;
use AppModules\Category\Domain\Entities\Category;
use AppModules\Category\Domain\Services\CategoryService;

class UpdateCategoryUseCase

{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function execute(int $id, UpdateCategoryDTO $categoryDTO): ?Category
    {
        return $this->categoryService->update($id, $categoryDTO);
    }
}
