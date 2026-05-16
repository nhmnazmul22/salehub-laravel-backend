<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "branchId" => $this->resource->branchId,
            "cuid" => $this->resource->cuid,
            "name" => $this->resource->name,
            "address" => $this->resource->address,
            "phone" => $this->resource->phone,
            "email" => $this->resource->email,
            "contactPerson" => $this->resource->contactPerson,
            "isActive" => $this->resource->isActive,
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
        ];
    }
}
