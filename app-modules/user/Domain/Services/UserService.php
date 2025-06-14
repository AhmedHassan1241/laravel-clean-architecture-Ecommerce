<?php

namespace AppModules\user\Domain\Services;

use AppModules\User\Application\DTOs\LoginUserDTO;
use AppModules\user\Application\DTOs\RegisterUserDTO;
use AppModules\User\Application\DTOs\UpdateUserDTO;
use AppModules\User\Domain\Entities\User;
use AppModules\User\Domain\Repositories\UserRepositoryInterface;

class UserService
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {

    }

    public function register(RegisterUserDTO $registerUserDTO): User
    {
        return $this->userRepository->register($registerUserDTO);

    }

    public function login(LoginUserDTO $loginUserDTO): ?User
    {
        return $this->userRepository->login($loginUserDTO);

    }

    public function update(int $id, UpdateUserDTO $userDTO): ?User
    {
//        $existingUser = $this->userRepository->findById($id);
//
//        if (!$existingUser) {
//            return null;
//        }
//        $existingUser->name = $userDTO->getName();
//        $existingUser->email = $userDTO->getEmail();
//        if ($userDTO->getPassword() !== null && $userDTO->getPassword() !== '') {
//            $existingUser->changePassword($userDTO->getPassword());
//        }
        return $this->userRepository->update($id, $userDTO);
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
