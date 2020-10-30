<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_paginate_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->times(10)->create();
        $url = route('api.products.index', [
            'page[size]' => 2,
            'page[number]' => 3,
        ]);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);
        $response->assertJsonFragment([
            'first' => route('api.products.index', ['page[number]' => 1, 'page[size]' => 2]),
            'last' => route('api.products.index', ['page[number]' => 5, 'page[size]' => 2]),
            'prev' => route('api.products.index', ['page[number]' => 2, 'page[size]' => 2]),
            'next' => route('api.products.index', ['page[number]' => 4, 'page[size]' => 2]),
        ]);
    }
}
