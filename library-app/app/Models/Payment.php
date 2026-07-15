<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $reservation_id
 * @property string $payment_code
 * @property float $amount
 * @property string|null $payment_proof
 * @property string $status
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 */
#[Fillable([
    'reservation_id', 'payment_code', 'amount', 'payment_proof',
    'status', 'verified_by', 'verified_at',
])]
class Payment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Generate a unique payment code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'PAY-' . strtoupper(substr(uniqid(), -6));
        } while (static::where('payment_code', $code)->exists());

        return $code;
    }
}
