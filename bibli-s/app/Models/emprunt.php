<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprunt extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'book_id',
    'borrower_name',
    'borrower_phone',
    'borrower_email',
    'loaned_at',
    'due_date',
    'returned_at',
    'status',
];

    protected $casts = [
        'loaned_at'   => 'date',
        'due_date'    => 'date',
        'returned_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class,);
    }

    public function livre(): BelongsTo
    {
        return $this->belongsTo(Livre::class, 'book_id');
    }

    public function isLate(): bool
    {
        return $this->returned_at === null && $this->due_date->isPast();
    }

    public function markAsReturned(): void
    {
        $this->update([
            'returned_at' => now(),
            'status'      => 'retourné',
        ]);

        $this->livre->increment('available_quantity');
    }
}