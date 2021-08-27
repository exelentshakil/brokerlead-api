<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'address' => $this->faker->address,
            'price' => $this->faker->numberBetween(99, 9999, ),
            'bed' => $this->faker->numberBetween(1, 5),
            'bathroom' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl,
            'year_built' => $this->faker->year,
            'user_id' => User::all()->random()->id
        ];
    }
}
