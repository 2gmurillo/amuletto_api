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
        $response = $this->jsonApi()->get(route('api.products.read', $product));

        //Assert
        $response->assertJson([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'photo' => $product->photo,
                    'price' => $product->price,
                    'description' => $product->description,
                    'stock' => $product->stock,
                    'disabledAt' => $product->disabled_at,
                    'userId' => $product->user_id,
                    'categoryId' => $product->category_id,
//                    'createdAt' => $product->created_at,
//                    'updatedAt' => $product->updated_at,
                ],
                'links' => [
                    'self' => url(route('api.products.read', $product)),
                ],
            ]
        ]);
    }
}
