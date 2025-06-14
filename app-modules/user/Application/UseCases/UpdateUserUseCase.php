<?php

namespace AppModules\User\Application\UseCases;

use AppModules\User\Application\DTOs\UpdateUserDTO;
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
