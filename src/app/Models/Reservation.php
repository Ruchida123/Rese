<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'date',
        'time',
        'number'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function shop(){
        return $this->belongsTo('App\Models\Shop');
    }

    public function scopeUserReserveShopsSearch($query, $user_id)
    {
        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }
    }

    public function scopeReserveShopsSearch($query, $user_id, $reserve_id)
    {
        if (!empty($user_id)) {
            $query->where('user_id', $user_id)->where('id', $reserve_id);
        }
    }

    public function scopeShopSearch($query, $shop_id)
    {
        if (!empty($shop_id)) {
            $query->where('shop_id', $shop_id);
        }
    }

    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            $query->where('date', $date);
        }
    }
}
