<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\ChangePasswordRequest;
use App\Http\Requests\API\Client\UpdateProfileRequest;
use App\Http\Resources\API\Client\ProfileResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth('client')->user();

        if (!$user->verifyPassword($request->old_password)) {
            return $this->failureResponse('كلمة المرور القديمة غير صحيحة');
        }
        $user->changePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }

}
