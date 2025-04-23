<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Auth\LoginAdminRequest;
use App\Http\Requests\API\Admin\Auth\RegisterAdminRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\API\Admin\AuthResource;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(RegisterAdminRequest $request)
    {
        if (Admin::exists()) {
            return $this->failureResponse('يوجد ادمن مسجل مسبقا');
        }
        Admin::create($request->validated());

        return $this->successResponse('تم تسجيل الادمن بنجاح');
    }

    public function login(LoginAdminRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }

        $token = $admin->login();

        return $this->successWithDataResponse(AuthResource::make($admin)->setToken($token));
    }

    public function logout()
    {
        auth('admin')->user()->tokens()->delete();
        return $this->successResponse('تم تسجيل الخروج بنجاح');
    }
}
