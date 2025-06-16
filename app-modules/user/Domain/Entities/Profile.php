<?php

namespace AppModules\User\Domain\Entities;

class Profile
{
    public function __construct(
        public readonly ?int $id = null,
        public int           $userId,
        public array         $user, // ← هذا مهم
        public string        $phone,
        public ?string       $address,
        public ?string       $date_of_birth,
        public ?string       $bio,
        public ?string       $image,
    )
    {
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}
