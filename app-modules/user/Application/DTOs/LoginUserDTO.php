<?php

namespace AppModules\User\Application\DTOs;


//This file Data Transfer To Object (DTO)
class LoginUserDTO
{
//    private string $hashedPassword;

    public function __construct(private string $email, private string $password)
    {
//        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

}
