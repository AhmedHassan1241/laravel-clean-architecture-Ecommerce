<?php

namespace AppModules\User\Presentation\Controllers;


use AppModules\User\Application\DTOs\Profile\UpdateProfileDTO;
use AppModules\User\Application\UseCases\Profile\ShowProfileUseCase;
use AppModules\User\Application\UseCases\Profile\UpdateProfileUseCase;
use AppModules\User\Presentation\Requests\Profile\UpdateProfileRequest;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(private ShowProfileUseCase $showProfileUseCase, private UpdateProfileUseCase $updateProfileUseCase)
    {

    }

//    public function store(StoreProfileRequest $request): JsonResponse
//    {
//        $data = $request->validated();
//        $data['image'] = $request->toDTO();
//        $profileDTO = new StoreProfileDTO($data['phone'], $data['address'] ?? null, $data['date_of_birth'] ?? null, $data['bio'] ?? null, $data['image'] ?? null);
//        $profile = $this->storeProfileUseCase->execute($profileDTO);
//        if ($profile === null) {
//            return response()->json(['message' => "This User Has Already Profile"]);
//        }
//        return response()->json(['message' => 'Profile Created Successfully', 'Profile' => $profile], 201);
//    }

    public function show(): JsonResponse
    {
        $profile = $this->showProfileUseCase->execute();
//        dd($profile);
        if ($profile === null) {
            return response()->json(['message' => "Profile Not Found !!"]);
        }
        return response()->json(['Profile' => $profile], 200);

    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->toDTO();
        $profileDTO = new UpdateProfileDTO($data['phone'] ?? null, $data['address'] ?? null, $data['date_of_birth'] ?? null, $data['bio'] ?? null, $data['image'] ?? null);

        $profile = $this->updateProfileUseCase->execute($profileDTO);

        if (!$profile) {
            return response()->json(['error' => " Updated Failed !!"], 403);

        }
        return response()->json(['message' => "Updated Successfully", 'profile' => $profile], 201);

    }


}

