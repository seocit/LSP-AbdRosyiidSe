<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $reservation_code
 * @property int $user_id
 * @property int $book_id
 * @property \Illuminate\Support\Carbon|null $reservation_date
 * @property \Illuminate\Support\Carbon|null $pickup_date
 * @property \Illuminate\Support\Carbon|null $return_date
 * @property string|null $note
 * @property string $status pending|approved|rejected|waiting_payment|completed|cancelled|returned
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 */
#[Fillable([
    'reservation_code', 'user_id', 'book_id', 'reservation_date',
    'pickup_date', 'return_date', 'note', 'status', 'verified_by', 'verified_at',
])]
class Reservation extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'pickup_date' => 'date',
            'return_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Generate a unique reservation code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'RSV-' . strtoupper(substr(uniqid(), -6));
        } while (static::where('reservation_code', $code)->exists());

        return $code;
    }
}
