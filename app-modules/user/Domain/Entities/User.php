<?php

namespace AppModules\User\Domain\Entities;


class User
{

    public function __construct(public int $id, public string $name, public string $role, public string $email, private string $password)
    {

    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
    }

}
