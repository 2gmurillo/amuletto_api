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
        $response = $this->getJson(route('api.products.index'));

        //Assert
        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'products',
                    'id' => (string)$products[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[0]->name,
                        'photo' => $products[0]->photo,
                        'price' => $products[0]->price,
                        'description' => $products[0]->description,
                        'category_id' => $products[0]->category_id,
                        'stock' => $products[0]->stock,
                    ],
                    'links' => [
                        'self' => url(route('api.products.show', $products[0])),
                    ],
                ],
                [
                    'type' => 'products',
                    'id' => (string)$products[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[1]->name,
                        'photo' => $products[1]->photo,
                        'price' => $products[1]->price,
                        'description' => $products[1]->description,
                        'category_id' => $products[1]->category_id,
                        'stock' => $products[1]->stock,
                    ],
                    'links' => [
                        'self' => url(route('api.products.show', $products[1])),
                    ],
                ],
                [
                    'type' => 'products',
                    'id' => (string)$products[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[2]->name,
                        'photo' => $products[2]->photo,
                        'price' => $products[2]->price,
                        'description' => $products[2]->description,
                        'category_id' => $products[2]->category_id,
                        'stock' => $products[2]->stock,
                    ],
                    'links' => [
                        'self' => url(route('api.products.show', $products[2])),
                    ],
                ],
            ],
            'links' => [
                'self' => url(route('api.products.index')),
            ],
            'meta' => [
                'products_count' => 3
            ]
        ]);
    }
}
