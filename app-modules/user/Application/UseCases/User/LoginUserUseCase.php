<?php

namespace AppModules\User\Application\UseCases\User;

use AppModules\User\Application\DTOs\User\LoginUserDTO;
use AppModules\User\Domain\Entities\User;
use AppModules\user\Domain\Services\UserService;

class LoginUserUseCase
{

    public function __construct(private UserService $service)
    {
    }

    public function execute(LoginUserDTO $loginUserDTO): ?User
    {
        //services form domain
        return $this->service->login($loginUserDTO);
    }
}
