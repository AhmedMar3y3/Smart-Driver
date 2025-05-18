<?php

namespace App\Http\Controllers\API\Client;

use App\Enums\Status;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\CarsResource;
use App\Http\Resources\API\Client\PlatesResource;
use App\Http\Resources\API\Client\ProfileResource;
use App\Http\Requests\API\Client\UpdateProfileRequest;
use App\Http\Requests\API\Client\ChangePasswordRequest;
use App\Http\Resources\API\Client\MyAttemptsResource;
use App\Http\Resources\API\Client\MyExamsResource;
use App\Http\Resources\API\Client\ReservationResource;

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

    public function myCars()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(CarsResource::collection($user->cars));
    }

    public function toggleCarAsSold($id)
    {
        $user = auth('client')->user();
        $car = $user->cars()->findOrFail($id);
        $car->update('status', Status::SOLD->value);
        return $this->successResponse('تم تغيير حالة السيارة بنجاح');
    }
    public function myPlates()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(PlatesResource::collection($user->plates));
    }

    public function togglePlateAsSold($id)
    {
        $user = auth('client')->user();
        $plate = $user->plates()->findOrFail($id);
        $plate->update('status', Status::SOLD->value);
        return $this->successResponse('تم تغيير حالة اللوحة بنجاح');
    }

    public function myReservations()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(ReservationResource::collection($user->reservations));
    }

    public function myQuestionPackages()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(MyExamsResource::collection($user->questionSubscriptions->where('status', 'active')));
    }
    public function myAttempets()
    {
        $user = auth('client')->user();
        return $this->successWithDataResponse(MyAttemptsResource::collection($user->questionSubscriptions->flatMap->exams));
    }
}
