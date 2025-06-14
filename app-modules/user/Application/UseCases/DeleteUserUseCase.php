<?php

namespace AppModules\User\Application\UseCases;


use AppModules\user\Domain\Services\UserService;

class DeleteUserUseCase
{
    function __construct(private UserService $userService)
    {

    }

    public function execute(int $id): bool
    {
        return $this->userService->delete($id);
    }

}
