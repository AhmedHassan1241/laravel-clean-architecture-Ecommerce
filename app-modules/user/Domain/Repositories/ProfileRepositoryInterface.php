<?php

namespace AppModules\User\Domain\Repositories;

use AppModules\User\Application\DTOs\Profile\UpdateProfileDTO;
use AppModules\User\Domain\Entities\Profile;

interface ProfileRepositoryInterface
{


    public function show(): ?Profile;

    public function update(UpdateProfileDTO $updateProfileDTO): ?Profile;


}
