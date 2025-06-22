<?php

namespace AppModules\Category\Application\UseCases;

use AppModules\Category\Domain\Services\CategoryService;

class AllCategoriesUseCase
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function execute(): ?array
    {
        return $this->categoryService->index();
    }

}
