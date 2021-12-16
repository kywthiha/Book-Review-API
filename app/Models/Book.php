<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'price',
        'author',
        'about_author',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id', 'id');
    }

    public function scopeAverageRatingAndRatingCount($query)
    {
        return $query
            ->leftJoin('book_reviews', 'book_reviews.book_id', '=', 'books.id')
            ->selectRaw('books.*,AVG(rating) as average_rating, COUNT(book_reviews.id) as rating_count')
            ->groupBy('books.id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($modal) {
            if (auth()->check()) {
                $modal->created_by = auth()->id();
            }
        });
    }
}
