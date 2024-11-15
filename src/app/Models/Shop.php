<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'region_id',
        'genre_id',
        'summary',
        'image_url',
    ];

    public function region(){
        return $this->belongsTo('App\Models\Region');
    }

    public function genre(){
        return $this->belongsTo('App\Models\Genre');
    }

    public function shopReview(){
        return $this->hasMany('App\Models\ShopReview');
    }

    public function scopeRegionSearch($query, $region_id)
    {
        if (!empty($region_id)) {
            $query->where('region_id', $region_id);
        }
    }

    public function scopeGenreSearch($query, $genre_id)
    {
        if (!empty($genre_id)) {
            $query->where('genre_id', $genre_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }
}
