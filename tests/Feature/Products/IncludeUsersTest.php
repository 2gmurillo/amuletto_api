<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncludeUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_include_users()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();
        $url = route('api.products.read', $product);

        //Act
        $response = $this->jsonApi()
            ->includePaths('user')
            ->get($url);

        //Assert
        $response->assertSee($product->user->name)
            ->assertJsonFragment([
                'related' => route('api.products.relationships.user', $product)
            ])
            ->assertJsonFragment([
                'self' => route('api.products.relationships.user.replace', $product)
            ]);
    }

    /** @test */
    public function it_can_fetch_related_users()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->create();
        $urlUser = route('api.products.relationships.user', $product);
        $urlRead = route('api.products.relationships.user.read', $product);

        //Act
        $responseUser = $this->jsonApi()->get($urlUser);
        $responseRead = $this->jsonApi()->get($urlRead);

        //Assert
        $responseUser->assertSee($product->user->name);
        $responseRead->assertSee($product->user->id);
        $this->assertNull($responseRead->json('data.relationships.user.data'),
        "The key 'data.relationships.user.data' must be null");
    }
}
