<?php

namespace AppModules\User\Application\Observers;


use AppModules\User\Infrastructure\Persistence\Models\ProfileModel;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;

class UserObserver
{
    /**
     * Handle the UserModel "created" event.
     */
    public function created(UserModel $userModel): void
    {
        //
        ProfileModel::create([
            'user_id' => $userModel->id,
            'phone' => '',
            'address' => '',
            'date_of_birth' => null,
            'bio' => '',
            'image' => null,
        ]);
    }

    /**
     * Handle the UserModel "updated" event.
     */
    public function updated(UserModel $userModel): void
    {
        //
    }

    /**
     * Handle the UserModel "deleted" event.
     */
    public function deleted(UserModel $userModel): void
    {
        //
    }

    /**
     * Handle the UserModel "restored" event.
     */
    public function restored(UserModel $userModel): void
    {
        //
    }

    /**
     * Handle the UserModel "force deleted" event.
     */
    public function forceDeleted(UserModel $userModel): void
    {
        //
    }
}
