<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'points_earned', 'points_redeemed'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
