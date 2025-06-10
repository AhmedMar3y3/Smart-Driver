<?php

namespace App\Http\Controllers\API\Captain;

use App\Models\Captain;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Captain\AuthResource;
use App\Http\Resources\API\Captain\RegisterResource;
use App\Http\Requests\API\Captain\Captain\LoginCaptainRequest;
use App\Http\Requests\API\Captain\Captain\RegisterCaptainRequest;
use App\Http\Requests\API\Captain\Password\ResetPasswordRequest;
use App\Http\Requests\API\Captain\Password\ResetPasswordSendCodeRequest;
use App\Http\Requests\API\Captain\Password\ResetPasswordCheckCodeRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(RegisterCaptainRequest $request)
    {
        $captain = Captain::create($request->validated());
        $token = $captain->createToken('captain-token')->plainTextToken;
        return $this->successWithDataResponse(RegisterResource::make($captain)->setToken($token));
    }

    public function login(LoginCaptainRequest $request)
    {
        $captain = Captain::where('email', $request->email)->first();
        if (!$captain || !Hash::check($request->password, $captain->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }
        $token = $captain->createToken('captain-token')->plainTextToken;
        return $this->successWithDataResponse(AuthResource::make($captain)->setToken($token));
    }

    public function logout()
    {
        try {
            Auth('captain')->user()->tokens()->delete();
            return $this->successResponse('تم تسجيل الخروج بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('فشل تسجيل الخروج: ' . $e->getMessage());
        }
    }

    public function refresh()
    {
        try {
            $captain = Auth('captain')->user();
            $token = $captain->createToken('captain-token')->plainTextToken;
            return $this->successWithDataResponse(AuthResource::make($captain)->setToken($token));
        } catch (\Exception $e) {
            return $this->failureResponse('فشل تحديث التوكن: ' . $e->getMessage());
        }
    }

    public function sendCode(ResetPasswordSendCodeRequest $request)
    {
        $user = Captain::where('email', $request->email)->first();
        $user->sendVerificationCodeForCaptain();
        return $this->successResponse();
    }

    public function checkCode(ResetPasswordCheckCodeRequest $request)
    {
        $user = Captain::where('email', $request->email)->first();

        if ($user->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        $user->update([
            'is_code'   => true,
        ]);

        return $this->successResponse();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = Captain::where('email', $request->email)->first();

        if ($user->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        if (! $user->is_code) {
            return $this->failureResponse('يرجي ارسال كود التفعيل');
        }

        $user->updatePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
