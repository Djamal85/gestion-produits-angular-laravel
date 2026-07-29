<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // Champs acceptés lors d'une création ou modification en masse.
    protected $fillable = ['name', 'description'];

    public function products(): HasMany
    {
        // Une catégorie peut regrouper plusieurs produits.
        return $this->hasMany(Product::class);
    }
}
