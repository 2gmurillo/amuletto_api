<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceObject extends JsonResource
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
            'type' => $this->resource->type,
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => $this->resource->fields(),
            'links' => [
                'self' => url(route('api.' . $this->resource->type . '.show', $this->resource)),
            ],
        ];
    }
}
