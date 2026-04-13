<?php

namespace App\Http\Resources\User;

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
            "id" => $this->resource->id,
            "firstName" => $this->resource->firstName,
            "lastName" => $this->resource->lastName,
            "role" => $this->resource->role,
            "email" => $this->resource->email,
            "email_verified_at" => $this->resource->email_verified_at,
            "branch" => $this->whenLoaded('branch', fn() => $this->resource->branch),
            "isActive" => $this->resource->isActive,
            "last_login" => $this->resource->last_login,
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
        ];
    }
}
