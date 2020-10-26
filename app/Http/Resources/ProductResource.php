<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array[]
     */
    public function toArray($request)
    {
        return [
            'type' => 'products',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'photo' => $this->resource->photo,
                'price' => $this->resource->price,
                'description' => $this->resource->description,
                'category_id' => $this->resource->category_id,
                'stock' => $this->resource->stock,
            ],
            'links' => [
                'self' => url(route('api.products.show', $this->resource)),
            ],
        ];
    }
}
