<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_products_by_price_asc()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create(['price' => 20000]);
        Product::factory()->create(['price' => 30000]);
        Product::factory()->create(['price' => 10000]);
        $url = route('api.products.index', ['sort' => 'price']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertSeeInOrder([
            10000,
            20000,
            30000,
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_price_desc()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create(['price' => 20000]);
        Product::factory()->create(['price' => 30000]);
        Product::factory()->create(['price' => 10000]);
        $url = route('api.products.index', ['sort' => '-price']);

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertSeeInOrder([
            30000,
            20000,
            10000,
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_price_and_name()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->create([
            'price' => 20000,
            'name' => 'C Name',
        ]);
        Product::factory()->create([
            'price' => 30000,
            'name' => 'A Name',
        ]);
        Product::factory()->create([
            'price' => 10000,
            'name' => 'B Name',
        ]);
        $url = route('api.products.index') . '?sort=-price,name';

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertSeeInOrder([
            30000,
            20000,
            10000,
        ]);

        //Arrange
        $url = route('api.products.index') . '?sort=name,-price';

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertSeeInOrder([
            30000,
            10000,
            20000,
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_unknown_fields()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        Product::factory()->times(3)->create();
        $url = route('api.products.index') . '?sort=unknown';

        //Act
        $response = $this->jsonApi()->get($url);

        //Assert
        $response->assertStatus(400);
    }
}
