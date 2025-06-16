<?php

namespace AppModules\User\Presentation\Controllers;

use AppModules\User\Application\DTOs\User\LoginUserDTO;
use AppModules\User\Application\DTOs\User\RegisterUserDTO;
use AppModules\User\Application\Services\AuthService;
use AppModules\User\Application\UseCases\User\LoginUserUseCase;
use AppModules\User\Application\UseCases\User\RegisterUserUseCase;
use AppModules\User\Presentation\Requests\User\LoginUserRequest;
use AppModules\User\Presentation\Requests\User\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{

    public function __construct(private RegisterUserUseCase $registerUserUseCase, private LoginUserUseCase $loginUserUseCase, private AuthService $authService)
    {
    }

    public function register(RegisterUserRequest $request): JsonResponse  //RegisterUserRequest for validate request
    {
        $data = $request->validated();

        $userDTO = new RegisterUserDTO($data['name'], $data['email'], $data['password'], $data['role'] ?? 'customer');
        $user = $this->registerUserUseCase->execute($userDTO);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function login(LoginUserRequest $loginUserRequest): JsonResponse
    {
        $data = $loginUserRequest->validated();
        $userDTO = new LoginUserDTO($data['email'], $data['password']);

        $user = $this->loginUserUseCase->execute($userDTO);
        $token = $this->authService->generateToken($user);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);

    }


    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => "User Logout Successfully"], 200);
    }


}
