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
            'is_approved' => $this->is_approved,
            'token' => $this->token,
        ];
    }
} 