<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1, true),
            'photo' => $this->faker->imageUrl($width = 450, $height = 400, 'abstract'),
            'price' => $this->faker->numberBetween(100, 500) * 100,
            'description' => $this->faker->paragraph(5),
            'category_id' => Category::factory(),
            'stock' => $this->faker->numberBetween(1, 100),
        ];
    }
}
