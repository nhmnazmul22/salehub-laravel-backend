<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "categoryId" => $this->resource->categoryId,
            'cuid' => $this->resource->cuid,
            "name" => $this->resource->name,
            "image" => $this->resource->image,
            "isActive" => $this->resource->isActive,
            "children" => CategoryWithChildrenResource::collection($this->whenLoaded('children')),
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
        ];
    }
}
