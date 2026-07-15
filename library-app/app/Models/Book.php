<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $author
 * @property string $publisher
 * @property string $publish_year
 * @property string|null $isbn
 * @property int $stock
 * @property string|null $cover
 * @property string|null $description
 */
#[Fillable(['category_id', 'title', 'author', 'publisher', 'publish_year', 'isbn', 'stock', 'cover', 'description'])]
class Book extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check whether the book has available stock.
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
}
