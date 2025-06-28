<?php

namespace AppModules\User\Infrastructure\Persistence\Repositories;

use AppModules\User\Application\DTOs\Profile\StoreProfileDTO;
use AppModules\User\Application\DTOs\Profile\UpdateProfileDTO;
use AppModules\User\Domain\Entities\Profile;
use AppModules\User\Domain\Repositories\ProfileRepositoryInterface;
use AppModules\User\Infrastructure\Persistence\Models\ProfileModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EloquentProfileRepository implements ProfileRepositoryInterface
{

    public function show(): ?Profile
    {
        $user_id = Auth::id();
        $profile = ProfileModel::with('user')->where('user_id', $user_id)->first();
        if (!$profile) {
            return null;
        }
        return $this->mapToDomain($profile);
    }

    private function mapToDomain(ProfileModel $profileModel): Profile
    {
//        return new Profile(
//            id: $profileModel->id,
//            userId: $profileModel->user_id,
//            user: [
//                'name' => $profileModel->user?->name,
//                'email' => $profileModel->user?->email,
//                'role' => $profileModel->user?->role,
//            ],
//            phone: $profileModel->phone,
//            address: $profileModel->address,
//            date_of_birth: $profileModel->date_of_birth,
//            bio: $profileModel->bio,
//            image: $profileModel->image
//        );
        return new Profile(
            id: $profileModel->id,
            userId: $profileModel->user_id,
            user: array_merge([
                'name' => $profileModel->user?->name,
                'email' => $profileModel->user?->email,
            ], Auth::user()?->role === 'admin' ? [
                'role' => $profileModel->user?->role
            ] : []),
            phone: $profileModel->phone,
            address: $profileModel->address,
            date_of_birth: $profileModel->date_of_birth,
            bio: $profileModel->bio,
            image: $profileModel->getImageUrl()

        );
    }

    public function update(UpdateProfileDTO $updateProfileDTO): Profile
    {
        $user_id = Auth::id();
        $profileModel = ProfileModel::where('user_id', $user_id)->first();
        if ($updateProfileDTO->getImage()) {
            Storage::disk('public')->delete($profileModel->image);
        }
        $profileModel->update([
            'phone' => $updateProfileDTO->getPhone() ?? $profileModel->phone,
            'address' => $updateProfileDTO->getAddress() ?? $profileModel->address,
            'date_of_birth' => $updateProfileDTO->getDateOfBirth() ?? $profileModel->date_of_birth,
            'bio' => $updateProfileDTO->getBio() ?? $profileModel->bio,
            'image' => $updateProfileDTO->getImage() ?? $profileModel->image,

        ]);
        return $this->mapToDomain($profileModel);
    }

}
