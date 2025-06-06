<?php

namespace App\Http\Resources\API\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     private $token;
     public function setToken($token){
         $this->token = $token;
 
         return $this;
     }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'role' => 'client',
            'image' => $this->image,
            'is_verified' => $this->is_verified,
            'token' => $this->token,
        ];
    }
}
