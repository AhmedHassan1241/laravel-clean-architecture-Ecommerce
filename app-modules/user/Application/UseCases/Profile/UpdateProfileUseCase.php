<?php

namespace AppModules\User\Application\UseCases\Profile;


use AppModules\User\Application\DTOs\Profile\UpdateProfileDTO;
use AppModules\User\Domain\Entities\Profile;
use AppModules\User\Domain\Services\ProfileService;

class UpdateProfileUseCase
{
    public function __construct(private ProfileService $profileService)
    {

    }

    public function execute(UpdateProfileDTO $updateProfileDTO): ?Profile
    {
        return $this->profileService->update($updateProfileDTO);
    }

}
