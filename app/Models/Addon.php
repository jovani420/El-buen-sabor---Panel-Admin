<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'price'];

    /**
     * The products that belong to the addon.
     */
    public function products(): BelongsToMany
    {
        // La corrección está aquí: "belongsToMany" con 'b' minúscula.
        return $this->belongsToMany(Product::class);
    }
}