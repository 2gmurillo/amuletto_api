<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_a_single_product()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        $response = $this->getJson(route('api.products.show', $product));

        //Assert
        $response->assertExactJson([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => $product->name,
                    'photo' => $product->photo,
                    'price' => $product->price,
                    'description' => $product->description,
                    'category_id' => $product->category_id,
                    'stock' => $product->stock,
                ],
                'links' => [
                    'self' => url(route('api.products.show', $product)),
                ],
            ]
        ]);
    }
}
