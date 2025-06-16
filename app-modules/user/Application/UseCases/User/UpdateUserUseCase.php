<?php

namespace AppModules\User\Application\UseCases\User;

use AppModules\User\Application\DTOs\User\UpdateUserDTO;
use AppModules\user\Domain\Services\UserService;

class UpdateUserUseCase
{
    public function __construct(private UserService $userService)
    {

    }

    public function execute(int $id, UpdateUserDTO $userDTO)
    {

        return $this->userService->update($id, $userDTO);
    }
}
