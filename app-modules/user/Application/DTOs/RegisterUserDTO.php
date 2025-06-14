<?php

namespace AppModules\user\Application\DTOs;


//This file Data Transfer To Object (DTO)
class RegisterUserDTO
{
    private string $hashedPassword;

    public function __construct(private string $name, private string $email, private string $password, private string $role)
    {
        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
