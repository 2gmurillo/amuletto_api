<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_cannot_create_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $product = array_filter(Product::factory()->raw([
            'user_id' => null
        ]));

        //Act
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.products.create'));

        //Assert
        $response->assertStatusCode(401);
        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function authenticated_user_can_create_products()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $user = User::factory()->create();
        $product = array_filter(Product::factory()->raw([
            'user_id' => null
        ]));
        $this->assertDatabaseMissing('products', $product);

        //Act
        Sanctum::actingAs($user);
        Sanctum::actingAs($user);
        $response = $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.products.create'));

        //Assert
        $response->assertCreated();
        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => $product['name'],
            'slug' => $product['slug'],
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        //$this->withoutExceptionHandling();
        //Arrange
        $user = User::factory()->create();
        $product = Product::factory()->raw(['name' => '']);

        //Act
        Sanctum::actingAs($user);
        Sanctum::actingAs($user);
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
        $user = User::factory()->create();
        $product = Product::factory()->raw(['photo' => '']);

        //Act
        Sanctum::actingAs($user);
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

    /** @test */
    public function slug_is_required()
    {
        $user = User::factory()->create();
        $product = Product::factory()->raw(['slug' => '']);

        Sanctum::actingAs($user);
        $this->jsonApi()->withData([
            'type' => 'products',
            'attributes' => $product
        ])->post(route('api.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/slug');

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $user = User::factory()->create();
        Product::factory()->create(['slug' => 'same-slug']);
        $product = Product::factory()->raw(['slug' => 'same-slug']);

        Sanctum::actingAs($user);
        $this->jsonApi()->withData([
            'type' => 'products',
            'attributes' => $product
        ])->post(route('api.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/slug');

        $this->assertDatabaseMissing('products', $product);
    }

//    /** @test */
//    public function slug_must_must_only_contain_letters_numbers_and_dashes()
//    {
//        $user = User::factory()->create();
//        $product = Product::factory()->raw(['slug' => '#$^^%$']);
//
//        Sanctum::actingAs($user);
//        $this->jsonApi()->withData([
//            'type' => 'products',
//            'attributes' => $product
//        ])->post(route('api.products.create'))
//            ->assertStatus(422)
//            ->assertSee('data\/attributes\/slug');
//
//        $this->assertDatabaseMissing('products', $product);
//    }
//
//    /** @test */
//    public function slug_must_must_not_contain_underscores()
//    {
//        $user = User::factory()->create();
//        $product = Product::factory()->raw(['slug' => 'with_underscores']);
//
//        Sanctum::actingAs($user);
//        $this->jsonApi()->withData([
//            'type' => 'products',
//            'attributes' => $product
//        ])->post(route('api.products.create'))
//            ->assertSee(trans('validation.no_underscores', ['attribute' => 'slug']))
//            ->assertStatus(422)
//            ->assertSee('data\/attributes\/slug');
//
//        $this->assertDatabaseMissing('products', $product);
//    }
//
//    /** @test */
//    public function slug_must_must_not_start_with_dashes()
//    {
//        $user = User::factory()->create();
//        $product = Product::factory()->raw(['slug' => '-starts-with-dash']);
//
//        Sanctum::actingAs($user);
//        $this->jsonApi()->withData([
//            'type' => 'products',
//            'attributes' => $product
//        ])->post(route('api.products.create'))
//            ->assertSee(trans('validation.no_starting_dashes', ['attribute' => 'slug']))
//            ->assertStatus(422)
//            ->assertSee('data\/attributes\/slug');
//
//        $this->assertDatabaseMissing('products', $product);
//    }
//
//    /** @test */
//    public function slug_must_must_not_end_with_dashes()
//    {
//        $user = User::factory()->create();
//        $product = Product::factory()->raw(['slug' => 'ends-with-dash-']);
//
//        Sanctum::actingAs($user);
//        $this->jsonApi()->withData([
//            'type' => 'products',
//            'attributes' => $product
//        ])->post(route('api.products.create'))
//            ->assertSee(trans('validation.no_ending_dashes', ['attribute' => 'slug']))
//            ->assertStatus(422)
//            ->assertSee('data\/attributes\/slug');
//
//        $this->assertDatabaseMissing('products', $product);
//    }
//
//    /** @test
//     * @dataProvider not_valid_store_data_provider
//     * @param string $field
//     * @param mixed|null $value
//     */
//    public function it_cannot_store_a_product_when_store_data_is_not_valid(string $field, $value = null)
//    {
//        // Arrange
//        $data[$field] = $value;
//        $user = User::factory()->create();
//        $product = Product::factory()->raw($data);
//
//        // Act
//        Sanctum::actingAs($user);
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
