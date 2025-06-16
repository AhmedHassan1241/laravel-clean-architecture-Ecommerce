<?php

namespace AppModules\User\Application\DTOs\Profile;


//This file Data Transfer To Object (DTO)
class UpdateProfileDTO
{
    public function __construct(private ?string $phone, private ?string $address, private ?string $date_of_birth, private ?string $bio, private ?string $image)
    {

    }


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
    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
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
