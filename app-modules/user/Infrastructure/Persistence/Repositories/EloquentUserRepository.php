<?php

namespace AppModules\User\Infrastructure\Persistence\Repositories;

use AppModules\User\Application\DTOs\User\LoginUserDTO;
use AppModules\User\Application\DTOs\User\RegisterUserDTO;
use AppModules\User\Application\DTOs\User\UpdateUserDTO;
use AppModules\User\Domain\Entities\User;
use AppModules\User\Domain\Repositories\UserRepositoryInterface;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAll(): array
    {
        $users = UserModel::all();
        return $users->map(fn($userModel) => $this->mapToDomain($userModel))->toArray();
    }


    // take response query from DB convert to new User(....)
    private function mapToDomain(UserModel $userModel): User
    {
        return new User(
            id: $userModel->id,
            role: $userModel->role,
            name: $userModel->name,
            email: $userModel->email,
            password: $userModel->password,
        );
    }

    public function update(int $id, UpdateUserDTO $updateUserDTO): ?User
    {
        $userModel = UserModel::find($id);
        if (!$userModel) {
            return null;

        }

        $userModel->name = $updateUserDTO->getName();
        $userModel->email = $updateUserDTO->getEmail();
        if ($updateUserDTO->getPassword() !== null && $updateUserDTO->getPassword() !== '') {
            $userModel->password = bcrypt($updateUserDTO->getPassword());
        }

        $userModel->save();

        return $this->mapToDomain($userModel);

    }

//    public function update(int $id, UpdateUserDTO $updateUserDTO): ?User
//    {
//        // البحث عن المستخدم في قاعدة البيانات
//        $userModel = UserModel::find($id);
//        if (!$userModel) {
//            return null; // أو ترمي استثناء حسب تصميمك
//        }
//
//        // تحديث بيانات المستخدم في الـ Eloquent model
//        $userModel->name = $userDTO->getName();
//        $userModel->email = $userDTO->getEmail();
//        $userModel->password = bcrypt($userDTO->getPassword()); // تشفير كلمة السر
//
//        $userModel->save();
//
//        // تحويل الـ Eloquent model إلى كيان دومين وإرجاعه
//        return new User(
//            $userModel->id,
//            $userModel->name,
//            $userModel->email,
//            $userModel->password
//        );
//    }

    public function register(RegisterUserDTO $registerUserDTO): User
    {
        $user = new User(id: 0,
            name: $registerUserDTO->getName(),
            role: $registerUserDTO->getRole(),
            email: $registerUserDTO->getEmail(),
            password: $registerUserDTO->getHashedPassword());

        $userModel = new UserModel();

        $userModel->role = $user->getRole();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();
        $userModel->save();

        // تحديث الـ id في الدومين كيان لو كان جديد
        if (!$user->id) {
            $user->id = $userModel->id;
        }
        return $user;
    }

    public function login(LoginUserDTO $loginUserDTO): ?User
    {
        try {
            $userModel = UserModel::where('email', $loginUserDTO->getEmail())->firstOrFail();

            if (!Hash::check($loginUserDTO->getPassword(), $userModel->password)) {
                throw new AuthenticationException("Invalid credentials");

            }
        } catch (ModelNotFoundException $e) {
            throw new AuthenticationException("Invalid credentials");
        }

        return $this->mapToDomain($userModel);

    }

    public function delete(int $id): bool
    {
//        $user = UserModel::find($id);
        $user = $this->findById($id);
        if (!$user) {
            return false;
        }
        UserModel::destroy($id);
        return true;
    }

    public function findById(int $id): ?User
    {
        $userModel = UserModel::find($id);
        if (!$userModel) return null;
        return $this->mapToDomain($userModel);
    }
}
