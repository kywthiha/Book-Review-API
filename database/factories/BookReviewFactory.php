<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookReviewFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'rating' => $this->faker->shuffle(array(1,2,3,4,5))[0],
            'review' => $this->faker->text(),
        ];
    }
}
