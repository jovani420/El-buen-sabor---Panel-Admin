<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image', 'is_featured', 'is_daily_deal', 'allergens'];

    protected $casts = [
        'allergens' => 'array',
    ];

    // Indica que los accesores deben incluirse cuando el modelo se convierte a JSON
    protected $appends = ['image_url']; 
    
      public function getImageUrlAttribute(): string
    {
        // Si el campo 'image' está vacío, devolvemos una URL de placeholder o vacía.
        if (!$this->image) {
            return ''; // O una URL de imagen por defecto
        }

        // Usa Storage::url() que genera la URL pública completa.
        // Asume que la base del storage está configurada correctamente (ej: app_url/storage)
        return Storage::url($this->image);
    }

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
