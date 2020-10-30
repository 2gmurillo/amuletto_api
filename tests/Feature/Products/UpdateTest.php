<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function gests_users_cannot_update_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        $response = $this->jsonApi()
            ->patch(route('api.products.update', $product));

        //Assert
        $response->assertStatusCode(401);
    }

    /** @test */
    public function authenticated_users_can_update_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        Sanctum::actingAs($product->user);
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'id' => $product->getRouteKey(),
                'attributes' => [
                    'name' => 'Updated Name',
                    'slug' => 'updated-name',
                ],
            ]
        ])->patch(route('api.products.update', $product));

        //Assert
        $response->assertStatusCode(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Updated Name',
            'slug' => 'updated-name',
        ]);
    }

    /** @test */
    public function authenticated_users_can_update_the_product_name()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        Sanctum::actingAs($product->user);
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'id' => $product->getRouteKey(),
                'attributes' => [
                    'name' => 'Updated Name',
                ],
            ]
        ])->patch(route('api.products.update', $product));

        //Assert
        $response->assertStatusCode(200);
        $this->assertDatabaseHas('products', [
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function authenticated_users_can_update_the_product_slug()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        Sanctum::actingAs($product->user);
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'id' => $product->getRouteKey(),
                'attributes' => [
                    'slug' => 'updated-name',
                ],
            ]
        ])->patch(route('api.products.update', $product));

        //Assert
        $response->assertStatusCode(200);
        $this->assertDatabaseHas('products', [
            'slug' => 'updated-name',
        ]);
    }
}
