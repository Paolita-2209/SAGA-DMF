<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class emprunt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
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

    // Un emprunt appartient à un utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Un emprunt appartient à un livre
    public function livres(): BelongsTo
    {
        return $this->belongsTo(livre::class);
    }

    // Vérifie si l'emprunt est en retard
    public function isLate(): bool
    {
        return $this->returned_at === null
            && $this->due_date->isPast();
    }

    // Marque l'emprunt comme retourné
    public function markAsReturned(): void
    {
        $this->update([
            'returned_at' => now(),
            'status'      => 'retourné',
        ]);
    }
}
