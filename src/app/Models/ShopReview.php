<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'shop_id',
        'evaluate',
        'comment',
    ];

    public function scopeUserShopReviewSearch($query, $user_id, $shop_id)
    {
        if (!empty($user_id) and !empty($shop_id)) {
            $query->where('user_id', $user_id)
            ->where('shop_id', $shop_id);
        }
    }
}
