<?php

namespace AppModules\User\Presentation\Controllers;

use AppModules\User\Application\DTOs\UpdateUserDTO;
use AppModules\User\Application\UseCases\DeleteUserUseCase;
use AppModules\User\Application\UseCases\GetAllUserCase;
use AppModules\User\Application\UseCases\GetUserByIdUseCase;
use AppModules\User\Application\UseCases\UpdateUserUseCase;
use AppModules\User\Presentation\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller
{

    public function __construct(private UpdateUserUseCase $updateUserUseCase)
    {
    }

    public function index(GetAllUserCase $getAllUserCase): JsonResponse
    {
        $users = $getAllUserCase->execute();
        return response()->json($users);
    }


    public function show(int $id, GetUserByIdUseCase $userByIdUseCase): JsonResponse
    {
        $user = $userByIdUseCase->execute($id);
        if (!$user) {
            return response()->json(['message' => "User Not Found !!"], 404);
        }
        return response()->json($user);
    }

    public function update(int $id, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        $data = $updateUserRequest->validated();
        $updateUserDTO = new UpdateUserDTO($id, $data['name'] ?? '', $data['email'] ?? '', $data['password'] ?? null);
        $updateUser = $this->updateUserUseCase->execute($id, $updateUserDTO);
        return response()->json(['message' => "User Updated Successfully", 'User' => $updateUser], 200);

    }

    public function delete(int $id, DeleteUserUseCase $useCase): JsonResponse
    {
        $user = $useCase->execute($id);
        if (!$user) {
            return response()->json(["message" => "User Not Found !!"], 404);

        }

        return response()->json([
            "message" => "User deleted successfully",
            "deleted_user_id" => $id], 200);

    }

}
