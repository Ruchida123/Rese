<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
    ];

    public function scopeFavoriteShopSearch($query, $user_id, $shop_id)
    {
        if (!empty($user_id) and !empty($shop_id)) {
            $query->where('user_id', $user_id)
            ->where('shop_id', $shop_id);
        }
    }

    public function scopeUserFavoriteShopsSearch($query, $user_id)
    {
        if (!empty($user_id) and !empty($shop_id)) {
            $query->where('user_id', $user_id)
            ->where('shop_id', $shop_id);
        }
    }
}
