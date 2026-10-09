<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'quantity',
        'available_quantity',
        'image',
        'description',
    ];

    // Un livre appartient à une catégorie
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    // Un livre a plusieurs emprunts
    public function livres(): HasMany
    {
        return $this->hasMany(livre::class);
    }

    // Vérifie si le livre est disponible
    public function isAvailable(): bool
    {
        return $this->available_quantity > 0;
    }
}

