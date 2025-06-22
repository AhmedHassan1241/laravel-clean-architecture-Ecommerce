<?php

namespace AppModules\Category\Application\UseCases;

use AppModules\Category\Application\DTOs\StoreCategoryDTO;
use AppModules\Category\Domain\Entities\Category;
use AppModules\Category\Domain\Services\CategoryService;

class StoreCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function execute(StoreCategoryDTO $categoryDTO): ?Category
    {
        return $this->categoryService->store($categoryDTO);
    }

}
