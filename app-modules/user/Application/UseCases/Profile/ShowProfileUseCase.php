<?php

namespace AppModules\User\Application\UseCases\Profile;


use AppModules\User\Domain\Entities\Profile;
use AppModules\User\Domain\Services\ProfileService;

class ShowProfileUseCase
{
    public function __construct(private ProfileService $profileService)
    {

    }

    public function execute(): ?Profile
    {

        return $this->profileService->show();
    }

}
