<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $products = Product::factory()->times(3)->create();

        //Act
        $response = $this->jsonApi()->get(route('api.products.index'));

        //Assert
        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'products',
                    'id' => (string)$products[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[0]->name,
                        'slug' => $products[0]->slug,
                        'photo' => $products[0]->photo,
                        'price' => $products[0]->price,
                        'description' => $products[0]->description,
                        'stock' => $products[0]->stock,
                        'disabledAt' => $products[0]->disabled_at,
                        'userId' => $products[0]->user_id,
                        'categoryId' => $products[0]->category_id,
                        'createdAt' => $products[0]->created_at,
                        'updatedAt' => $products[0]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.products.read', $products[0])),
                    ],
                ],
                [
                    'type' => 'products',
                    'id' => (string)$products[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[1]->name,
                        'slug' => $products[1]->slug,
                        'photo' => $products[1]->photo,
                        'price' => $products[1]->price,
                        'description' => $products[1]->description,
                        'stock' => $products[1]->stock,
                        'disabledAt' => $products[1]->disabled_at,
                        'userId' => $products[1]->user_id,
                        'categoryId' => $products[1]->category_id,
                        'createdAt' => $products[1]->created_at,
                        'updatedAt' => $products[1]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.products.read', $products[1])),
                    ],
                ],
                [
                    'type' => 'products',
                    'id' => (string)$products[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[2]->name,
                        'slug' => $products[2]->slug,
                        'photo' => $products[2]->photo,
                        'price' => $products[2]->price,
                        'description' => $products[2]->description,
                        'stock' => $products[2]->stock,
                        'disabledAt' => $products[2]->disabled_at,
                        'userId' => $products[2]->user_id,
                        'categoryId' => $products[2]->category_id,
                        'createdAt' => $products[2]->created_at,
                        'updatedAt' => $products[2]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.products.read', $products[2])),
                    ],
                ],
            ]
        ]);
    }
}
