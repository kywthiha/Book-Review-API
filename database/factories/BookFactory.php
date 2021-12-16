<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(20),
            'description' => $this->faker->text(),
            'image_url' => $this->faker->imageUrl(),
            'price' => $this->faker->randomNumber(5),
            'author' =>  $this->faker->text(),
            'about_author' => $this->faker->text(),
        ];
    }
}
