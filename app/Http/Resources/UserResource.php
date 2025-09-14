<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nick_name' => $this->nick_name,
            'user_name' => $this->user_name, // Unique per user. Used when the user wants to share his profile link.
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'role' => $this->role,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'location' => $this->location,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'has_auth_account' => $this->has_auth_account,
            'is_email_verified' => $this->is_email_verified,
            'is_phone_verified' => $this->is_phone_verified,
            'login_count' => $this->login_count,
            'last_login' => $this->last_login,
        ];
    }
}
