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

    // Mantenemos 'image_url' si lo necesitas para otras cosas, pero lo de abajo lo anula
    protected $appends = ['image_url']; 
    
    // =================================================================
    // 💡 ACCESOR PARA SOBREESCRIBIR EL CAMPO 'image' EN EL JSON
    // =================================================================
    /**
     * Get the product's image path for API serialization.
     * Este método se llama cada vez que se lee el atributo 'image'.
     *
     * @param  string|null  $value El valor original de la DB (ej: product-images/...).
     * @return string
     */
    public function getImageAttribute(?string $value): string
    {
        if (empty($value)) {
            return ''; 
        }

        // Definimos el prefijo exacto que quieres que preceda a la ruta
        // El slash inicial es crucial para indicar que es una ruta absoluta desde la base del servidor.
        $basePath = '/panel-admin/storage/app/private/'; 

        // Retorna la ruta completa: /panel-admin/storage/app/private/product-images/...
        return $basePath . $value;
    }
    
    // =================================================================
    // 💡 ACCESOR PARA 'image_url' (Mantienes la lógica de URL web si la necesitas)
    // =================================================================
    public function getImageUrlAttribute(): string
    {
        // Importante: Aquí debes usar el valor ORIGINAL de la base de datos 
        // para evitar un bucle infinito o usar una ruta incorrecta con Storage::url().
        $rawImage = $this->getAttributeValue('image'); 

        if (!$rawImage) {
             return ''; // O la URL de tu placeholder
        }

        // Si realmente quieres que este campo genere una URL web completa:
        // return Storage::url($rawImage); 
        
        // Si no necesitas este campo 'image_url' en el JSON, puedes eliminarlo de $appends.
        // Por ahora, lo dejamos vacío para que solo se use el campo 'image' modificado.
        return ''; 
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class);
    }
}
