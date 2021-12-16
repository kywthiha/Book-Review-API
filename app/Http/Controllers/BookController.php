<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookDeleteRequest;
use App\Http\Requests\BookReviewStoreRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Traits\ResponserTrait;
use App\Models\Book;
use App\Models\BookReview;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{

    use ResponserTrait;

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::query()
            ->with(['createdBy', 'reviews.user'])
            ->averageRatingAndRatingCount()
            ->latest()
            ->paginate(10);
        return $this->respondCollection('Success', $books);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        return $this->respondCollection('Success', $this->bookService->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $book = Book::query()
            ->with(['createdBy', 'reviews.user'])
            ->averageRatingAndRatingCount()->where(
                ['books.id' => $book->id]
            )->first();
        return $this->respondCollection('Success', $book);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        return $this->respondCollection('Success', $this->bookService->update($request, $book));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookDeleteRequest $bookDeleteRequest, Book $book)
    {
        $book->delete();
        return $this->respondSuccessMsgOnly('Success');
    }

    public function report()
    {
        $books = Book::query()
            ->with(['createdBy', 'reviews.user'])
            ->averageRatingAndRatingCount()
            ->latest('rating_count')
            ->take(5)->get();
        return $this->respondCollection('Success', $books);
    }


    public function storeReview(BookReviewStoreRequest $request, Book $book)
    {
        return $this->respondCollection('Success', $this->bookService->storeReview($request, $book));
    }

    public function deleteReview(Request $request, Book $book)
    {
        return $this->respondCollection('Success', $this->bookService->deleteReview($request, $book));
    }
}
