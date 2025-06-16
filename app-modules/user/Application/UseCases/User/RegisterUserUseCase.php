<?php

namespace AppModules\User\Application\UseCases\User;

use AppModules\User\Application\DTOs\User\RegisterUserDTO;
use AppModules\User\Domain\Entities\User;
use AppModules\user\Domain\Services\UserService;

class RegisterUserUseCase
{

    public function __construct(private UserService $service)
    {
    }

    public function execute(RegisterUserDTO $registerUserDTO): User
    {
        //services form domain
        return $this->service->register($registerUserDTO);
    }
}
