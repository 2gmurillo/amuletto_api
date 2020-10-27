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
        $products = Product::factory()->times(10)->create();
        $url = route('api.products.index', [
            'page[size]' => 2,
            'page[number]' => 3,
        ]);

        //Act
        $response = $this->getJson($url);

        //Assert
        $response->assertJsonCount(2, 'data')
            ->assertDontSee($products[0]->name)
            ->assertDontSee($products[1]->name)
            ->assertDontSee($products[2]->name)
            ->assertDontSee($products[3]->name)
            ->assertSee($products[4]->name)
            ->assertSee($products[5]->name)
            ->assertDontSee($products[6]->name)
            ->assertDontSee($products[7]->name)
            ->assertDontSee($products[8]->name)
            ->assertDontSee($products[9]->name);
        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);
        $response->assertJsonFragment([
            'first' => route('api.products.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last' => route('api.products.index', ['page[size]' => 2, 'page[number]' => 5]),
            'prev' => route('api.products.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next' => route('api.products.index', ['page[size]' => 2, 'page[number]' => 4]),
        ]);
    }
}
