<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncludeUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_test()
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
        $response->assertSee($product->user->name);
    }
}
