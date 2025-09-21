<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image', 'is_featured', 'is_daily_deal', 'allergens'];

    protected $casts = [
        'allergens' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // AÑADE ESTE MÉTODO PARA DEFINIR LA RELACIÓN
    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class);
    }
}
