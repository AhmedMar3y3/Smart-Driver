<?php

namespace App\Http\Controllers\API\Client;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\ProfileResource;
use App\Http\Requests\API\Client\UpdateProfileRequest;
use App\Http\Requests\API\Client\ChangePasswordRequest;


class ProfileController extends Controller
{
    use HttpResponses;
    public function getProfile()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(new ProfileResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth('client')->user();
        $user->update($request->validated());
        return $this->successWithDataResponse(new ProfileResource($user));
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth('client')->user();

        if (!$user->verifyPassword($request->old_password)) {
            return $this->failureResponse('كلمة المرور القديمة غير صحيحة');
        }
        $user->changePassword($request->password);
        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
