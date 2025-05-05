<?php

namespace App\Http\Controllers\API\Captain;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\ProfileResource;
use App\Http\Requests\API\Captain\Info\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $captain = Auth('captain')->user();
        return $this->successWithDataResponse(new ProfileResource($captain));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $captain = Auth('captain')->user();

        if (!$captain->verifyPassword($request->old_password)) {
            return $this->failureResponse('كلمة المرور القديمة غير صحيحة');
        }
        $captain->changePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
