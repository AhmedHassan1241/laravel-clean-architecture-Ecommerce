<?php

namespace AppModules\Category\Application\UseCases;

use AppModules\Category\Domain\Services\CategoryService;

class DeleteCategoryUseCase
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function execute(int $id): bool
    {
        return $this->categoryService->destroy($id);
    }

}
