<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'profile_image_path' => Storage::disk('s3')->url($this->profile_image_path),
            'background_image_path' => Storage::disk('s3')->url($this->background_image_path),
            'bio' => $this->bio,
        ];
    }
}
