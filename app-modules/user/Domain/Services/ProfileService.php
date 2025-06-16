<?php

namespace AppModules\User\Domain\Services;

use AppModules\User\Application\DTOs\Profile\StoreProfileDTO;
use AppModules\User\Application\DTOs\Profile\UpdateProfileDTO;
use AppModules\User\Domain\Entities\Profile;
use AppModules\User\Domain\Repositories\ProfileRepositoryInterface;

class ProfileService
{

    public function __construct(private ProfileRepositoryInterface $profileRepository)
    {

    }


    public function update(UpdateProfileDTO $updateProfileDTO): ?Profile
    {
        $existingProfile = $this->profileRepository->show();
        if (!$existingProfile) {
            return null;
        }

        return $this->profileRepository->update($updateProfileDTO);
    }


    public function show(): ?Profile
    {
        return $this->profileRepository->show();
    }

}
