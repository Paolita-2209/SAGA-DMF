<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livre extends Model

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

    public function livres()
{
    return $this->hasMany(Livre::class, 'category_id');
}

    public function categorie()
{
    return $this->belongsTo(Categorie::class, 'category_id');
}

    public function isAvailable(): bool
    {
        return $this->available_quantity > 1;
    }
}