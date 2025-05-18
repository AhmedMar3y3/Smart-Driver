<?php

namespace App\Http\Controllers\API\Client;

use App\Models\Client;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Client\AuthResource;
use App\Http\Requests\API\Client\Client\LoginClientRequest;
use App\Http\Requests\API\Client\Client\VerifyClientRequest;
use App\Http\Requests\API\Client\Client\RegisterClientRequest;


class AuthController extends Controller
{
    use HttpResponses;
    public function register(RegisterClientRequest $request)
    {
        $client = Client::create($request->validated());
        $client->sendVerificationCode();
        return $this->successWithDataResponse(AuthResource::make($client));
    }

     public function verifyEmail(VerifyClientRequest $request)
    {
        $client = Client::where('email', $request->email)->first();

        if (!$client) {
            return $this->failureResponse('المستخدم غير موجود');
        }

        if ($client->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        $client->markAsVerified();
        return $this->successWithDataResponse(AuthResource::make($client)->setToken($client->login()));
    }

    public function login(LoginClientRequest $request)
    {
        $client = Client::where('email', $request->email)->first();
        if (!$client || !Hash::check($request->password, $client->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }
        return $this->successWithDataResponse(AuthResource::make($client)->setToken($client->login()));
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $client = Client::where('email', $googleUser->email)->first();

            if (!$client) {
                $client = Client::createWithGoogle([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'avatar' => $googleUser->avatar,
                ]);
            }

            $token = $client->createToken('client-token')->plainTextToken;

            return $this->successWithDataResponse(AuthResource::make($client)->setToken($token));
        } catch (\Exception $e) {
            return $this->failureResponse('فشل تسجيل الدخول بواسطة جوجل: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {

            Auth('client')->user()->tokens()->delete();
            return $this->successResponse('تم تسجيل الخروج بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse('فشل تسجيل الخروج: ' . $e->getMessage());
        }
    }
}
