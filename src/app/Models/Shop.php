<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\carbon;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'area_id',
        'genre_id',
        'user_id',
        'detail',
        'image',
    ];

    public function favorites() {
        return $this->hasMany('App\Models\Favorite');
    }
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }

    public function reservations() {
        return $this->belongsToMany('App\Models\User', 'reservations', 'shop_id', 'user_id')
                    ->as('content')
                    ->withPivot('id', 'date', 'time', 'number', 'payment');
    }

    public function area() {
        return $this->belongsTo('App\Models\Area');
    }
    public function genre() {
        return $this->belongsTo('App\Models\Genre');
    }
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeAreaSearch($query, $area_id)
    {
        if (!empty($area_id)) {
            $query->where('area_id', $area_id);
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

    public function getFavorite($shop_id) {
        $user_id = Auth::id();
        $favorite = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        return $favorite;
    }

    public function timeFormat($time) {
        $hourMinute = new Carbon($time);
        return $hourMinute->format('H:i');
    }
}
