<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->raw();
        $this->assertDatabaseMissing('products', $product);

        //Act
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.products.create'));

        //Assert
        $response->assertCreated();
        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function name_is_required()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->raw(['name' => '']);

        //Act
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.products.create'));

        //Assert
        $this->assertDatabaseMissing('products', $product);
        $response->assertStatusCode(422)
            ->assertSee('data\/attributes\/name');
    }

    /** @test */
    public function photo_is_required()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = Product::factory()->raw(['photo' => '']);

        //Act
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.products.create'));

        //Assert
        $this->assertDatabaseMissing('products', $product);
        $response->assertStatusCode(422)
            ->assertSee('data\/attributes\/photo');
    }

//    /** @test
//     * @dataProvider not_valid_store_data_provider
//     * @param string $field
//     * @param mixed|null $value
//     */
//    public function it_cannot_store_a_product_when_store_data_is_not_valid(string $field, $value = null)
//    {
//        // Arrange
//        $data[$field] = $value;
//        $product = Product::factory()->raw($data);
//
//        // Act
//        $response = $this->jsonApi()->content([
//            'data' => [
//                'type' => 'products',
//                'attributes' => $data,
//            ]
//        ])->post(route('api.products.create'));
//
//        // Assert
//        $this->assertDatabaseMissing('products', $product);
//        $response->assertStatusCode(422);
//        //$response->assertRedirect();
//        //$response->assertSessionHasErrors($field);
//    }
//
//    /**
//     * @return array
//     */
//    public function not_valid_store_data_provider(): array
//    {
//        return [
//            'Test name is required' => ['name', null],
//            'Test photo is required' => ['photo', null],
//        ];
//    }
}
