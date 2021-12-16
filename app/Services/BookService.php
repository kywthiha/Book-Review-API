<?php

namespace App\Services;

use App\Http\Requests\BookReviewStoreRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BookService
{

    public function store(BookStoreRequest $request): Book
    {
        return Book::create($request->validated());
    }

    public function update(BookUpdateRequest $request, Book $book): Book
    {
        $book->update($request->validated());
        return $book;
    }

    public function storeReview(BookReviewStoreRequest $request, Book $book): Book
    {
        BookReview::query()->updateOrCreate(
            ['book_id' => $book->id, 'user_id' => $request->user()->id],
            $request->validated()
        );
        $book->load('reviews');
        return $book;
    }

    public function deleteReview(Request $request,Book $book): Book
    {
        BookReview::query()
            ->where(['book_id' => $book->id, 'user_id' => $request->user()->id])
            ->delete();
        $book->load('reviews');
        return $book;
    }
}
