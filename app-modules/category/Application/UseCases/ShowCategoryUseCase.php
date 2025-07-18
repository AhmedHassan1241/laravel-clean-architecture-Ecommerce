<?php

namespace AppModules\Category\Application\UseCases;

use AppModules\Category\Domain\Services\CategoryService;

class ShowCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function execute(int $id): ?array
    {
        return $this->categoryService->show($id);
    }

}
