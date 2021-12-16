<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\User;
use Database\Factories\BookReviewFactory;
use Illuminate\Database\Seeder;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::query()->take(20)->get() as $user) {
            $books = Book::query()->inRandomOrder()->select('id')->take(10)->get();
            foreach($books as $book){
                BookReview::query()->updateOrCreate(
                    [
                        'user_id'=>$user->id,
                        'book_id'=>$book->id,
                    ],
                    BookReview::factory()->make()->toArray()
                );
            }

        }
    }
}
