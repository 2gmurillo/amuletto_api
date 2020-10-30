<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_cannot_delete_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        $response = $this->jsonApi()
            ->delete(route('api.products.delete', $product));

        //Assert
        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_delete_own_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        Sanctum::actingAs($product->user);

        $response = $this->jsonApi()
            ->delete(route('api.products.delete', $product));

        //Assert
        $response->assertStatus(204);
    }

    /** @test */
    public function authenticated_users_cannot_delete_other_users_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();

        //Act
        Sanctum::actingAs($user = User::factory()->create());

        $response = $this->jsonApi()
            ->delete(route('api.products.delete', $product));

        //Assert
        $response->assertStatus(403);
    }
}
