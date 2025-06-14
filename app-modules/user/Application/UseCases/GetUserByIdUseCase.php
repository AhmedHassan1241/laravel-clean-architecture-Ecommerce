<?php

namespace AppModules\User\Application\UseCases;

use AppModules\User\Domain\Repositories\UserRepositoryInterface;

class GetUserByIdUseCase
{
    private UserRepositoryInterface $userRepository;
public  function __construct(UserRepositoryInterface $userRepository)
{
$this->userRepository=$userRepository;
}
public function execute(int $id)
{
    return $this->userRepository->findById($id);
}
}
