<?php

namespace AppModules\User\Application\UseCases;


use AppModules\User\Domain\Repositories\UserRepositoryInterface;

class GetAllUserCase
{
private UserRepositoryInterface $userRepository;

public function __construct(UserRepositoryInterface $userRepository){
    $this->userRepository =$userRepository;
}

public function execute():array
{
    return $this->userRepository->getAll();
}

}
