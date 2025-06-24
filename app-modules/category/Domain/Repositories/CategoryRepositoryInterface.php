<?php

namespace AppModules\Category\Domain\Repositories;


use AppModules\Category\Application\DTOs\StoreCategoryDTO;
use AppModules\Category\Application\DTOs\UpdateCategoryDTO;
use AppModules\Category\Domain\Entities\Category;

interface CategoryRepositoryInterface
{
    public function store(StoreCategoryDTO $categoryDTO): ?Category;

    public function update(int $id, UpdateCategoryDTO $categoryDTO): ?Category;

    public function show(int $id): ?array;

    public function index(): ?array;

    public function destroy(int $id): bool;


}
