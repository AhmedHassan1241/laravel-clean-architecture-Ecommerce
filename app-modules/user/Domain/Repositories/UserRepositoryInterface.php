<?php

namespace AppModules\User\Domain\Repositories;

use AppModules\User\Application\DTOs\LoginUserDTO;
use AppModules\user\Application\DTOs\RegisterUserDTO;
use AppModules\User\Application\DTOs\UpdateUserDTO;
use AppModules\User\Domain\Entities\User;

interface UserRepositoryInterface
{

    public function login(LoginUserDTO $user): ?User;  // ترجع مستخدم أو null لو مش موجود

    public function register(RegisterUserDTO $user): User; // تحفظ بيانات المستخدم

    public function update(int $id, UpdateUserDTO $updateUserDTO): ?User;

    public function findById(int $id): ?User;

//    public function update(int $id,UpdateUserDTO $updateUserRequest): ?User; // تعديل مستخدم بالمعرف
    public function delete(int $id): bool; // حذف مستخدم بالمعرف

    public function getAll(): array;  // ترجع مصفوفة من المستخدمين

}
