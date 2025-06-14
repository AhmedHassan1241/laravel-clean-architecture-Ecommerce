<?php

namespace AppModules\User\Application\DTOs;


//This file Data Transfer To Object (DTO)
class UpdateUserDTO
{

//    public function __construct(private int $id, private ?string $name, private ?string $email, private ?string $password)
//    {
//
//    }
//
//    public function getId(): int
//    {
//        return $this->id;
//    }
//
//    public function getName(): ?string
//    {
//        return $this->name;
//    }
//
//    public function getEmail(): ?string
//    {
//        return $this->email;
//    }
//
//    public function getPassword(): ?string
//    {
//        return $this->password;
//    }
//}
    public function __construct(private int $id, private ?string $name, private ?string $email, private ?string $password)
    {

    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }


}


