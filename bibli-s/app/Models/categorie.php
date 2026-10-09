<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categorie extends Model
{
   protected $fillable = [
        'name',
        'description',
    ];

    // Une catégorie a plusieurs livres
    public function livre(): HasMany
    {
        return $this->hasMany(livre::class);
    }
}
