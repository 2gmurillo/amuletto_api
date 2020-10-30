<?php

namespace App\JsonApi\Products;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'products';

    /**
     * @param \App\Models\Product $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Product $product
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($product)
    {
        return [
            'name' => $product->name,
            'slug' => $product->slug,
            'photo' => $product->photo,
            'price' => (int)$product->price,
            'description' => $product->description,
            'stock' => $product->stock,
            'disabledAt' => $product->disabled_at,
            'userId' => $product->user_id,
            'categoryId' => $product->category_id,
            'createdAt' => $product->created_at,
            'updatedAt' => $product->updated_at,
        ];
    }
}
