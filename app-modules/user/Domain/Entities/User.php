<?php

namespace AppModules\User\Domain\Entities;


class User
{

    public function __construct(public int $id, public string $role, public string $name, public string $email, private string $password)
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
//    public int $id;
//    public string $name;
//    public string $email;
//    private string $password;
//
//    public function __construct(int $id, string $name, string $email, string $password)
//    {
//        $this->id = $id;
//        $this->name = $name;
//        $this->email = $email;
//        $this->password = $password;
//    }
//
//    public function getPassword(): string
//    {
//        return $this->password;
//    }
//
//    public function verifyPassword(string $password): bool
//    {
//        return password_verify($password, $this->password);
//    }
//
//    // دالة لتغيير كلمة السر مع التشفير
//    public function changePassword(string $newPassword): void
//    {
//        $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
//    }
}
