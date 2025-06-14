<?php

namespace AppModules\User\Infrastructure\Persistence\Repositories;

use AppModules\User\Application\DTOs\LoginUserDTO;
use AppModules\user\Application\DTOs\RegisterUserDTO;
use AppModules\User\Application\DTOs\UpdateUserDTO;
use AppModules\User\Domain\Entities\User;
use AppModules\User\Domain\Repositories\UserRepositoryInterface;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Auth\AuthenticationException;
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
            name: $userModel->name,
            email: $userModel->email, // ✅ صحيح
            role: $userModel->role,
            password: $userModel->password,
        );
    }

    public function update(int $id, UpdateUserDTO $userDTO): ?User
    {
        $userModel = UserModel::find($id);
        if (!$userModel) {
            return null;

        }

        $userModel->name = $userDTO->getName();
        $userModel->email = $userDTO->getEmail();
        if ($userDTO->getPassword() !== null && $userDTO->getPassword() !== '') {
            $userModel->password = bcrypt($userDTO->getPassword());
        }

        $userModel->save();

        return $this->mapToDomain($userModel);

    }

//    public function update(int $id, UpdateUserDTO $userDTO): ?User
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
            role: $registerUserDTO->getRole(),
            name: $registerUserDTO->getName(),
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
        $userModel = UserModel::where('email', $loginUserDTO->getEmail())->firstOrFail();
        if (!Hash::check($loginUserDTO->getPassword(), $userModel->password)) {
            throw new AuthenticationException("Invalid credentials");

        }

        return $this->mapToDomain($userModel); // ✅ الحل هنا

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
