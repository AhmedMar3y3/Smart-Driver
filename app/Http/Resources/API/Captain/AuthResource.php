<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    private $token;

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_approved' => $this->is_approved,
            'is_subscribed' => $this->isSubscribed(),
            'completed_info' => $this->completed_info,
            'role' => 'captain',
            'token' => $this->token,
        ];
    }
} 