<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_filter_products_by_name()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'name' => 'Amuletto product'
        ]);
        Product::factory()->create([
            'name' => 'Other product'
        ]);
        $url = route('api.products.index', ['filter[name]' => 'Amuletto']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(1, 'data')
            ->assertSee('Amuletto product')
            ->assertDontSee('Other Product');
    }

    /** @test */
    public function it_can_filter_products_by_description()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'description' => 'Amuletto product description'
        ]);

        Product::factory()->create([
            'description' => 'Other product description'
        ]);
        $url = route('api.products.index', ['filter[description]' => 'Amuletto']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(1, 'data')
            ->assertSee('Amuletto product description')
            ->assertDontSee('Other Product');
    }

    /** @test */
    public function it_can_filter_products_by_year()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'name' => 'Product from 2020',
            'created_at' => now()->year(2020)
        ]);

        Product::factory()->create([
            'name' => 'Product from 2021',
            'created_at' => now()->year(2021)
        ]);
        $url = route('api.products.index', ['filter[year]' => 2020]);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(1, 'data')
            ->assertSee('Product from 2020')
            ->assertDontSee('Product from 2021');
    }

    /** @test */
    public function it_can_filter_products_by_month()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'name' => 'Product from December',
            'created_at' => now()->month(12)
        ]);
        Product::factory()->create([
            'name' => 'Another Product from December',
            'created_at' => now()->month(12)
        ]);
        Product::factory()->create([
            'name' => 'Product from October',
            'created_at' => now()->month(10)
        ]);
        $url = route('api.products.index', ['filter[month]' => 12]);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(2, 'data')
            ->assertSee('Product from December')
            ->assertSee('Another Product from December')
            ->assertDontSee('Product from October');
    }

    /** @test */
    public function it_cannot_filter_products_by_unknown_filters()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create();
        $url = route('api.products.index', ['filter[unknown]' => 'unknown']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertStatus(400);
    }

    /** @test */
    public function it_can_search_products_by_name_and_description()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'name' => 'Product from Amuletto',
            'description' => 'Description'
        ]);
        Product::factory()->create([
            'name' => 'Another product',
            'description' => 'Description from Amuletto'
        ]);
        Product::factory()->create([
            'name' => 'Dont show',
            'description' => 'Dont show'
        ]);
        $url = route('api.products.index', ['filter[search]' => 'Amuletto']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(2, 'data')
            ->assertSee('Product from Amuletto')
            ->assertSee('Description from Amuletto')
            ->assertDontSee('Dont show');
    }

    /** @test */
    public function it_can_search_products_by_name_and_description_with_multiple_terms()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'name' => 'Product from Amuletto',
            'description' => 'Description'
        ]);
        Product::factory()->create([
            'name' => 'Another product',
            'description' => 'Description from Amuletto'
        ]);
        Product::factory()->create([
            'name' => 'Another Evertec product',
            'description' => 'Description'
        ]);
        Product::factory()->create([
            'name' => 'Dont show',
            'description' => 'Dont show'
        ]);
        $url = route('api.products.index', ['filter[search]' => 'Amuletto Evertec']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertJsonCount(3, 'data')
            ->assertSee('Product from Amuletto')
            ->assertSee('Description from Amuletto')
            ->assertSee('Another Evertec product')
            ->assertDontSee('Dont show');
    }
}
