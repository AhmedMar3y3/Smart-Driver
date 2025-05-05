<?php

namespace App\Http\Resources\API\Captain;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            'is_approved' => false,
            'is_subscribed' => false,
            'completed_info' => false,
            'token' => $this->token,
        ];
    }
}
