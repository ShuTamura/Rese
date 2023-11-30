<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favorites() {
        return $this->belongsToMany('App\Models\Shop', 'favorites');
    }
    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_users', 'user_id', 'role_id');
    }
    public function shop() {
        return $this->hasOne('App\Models\Shop');
    }
    public function reservations() {
        return $this->belongsToMany('App\Models\Shop', 'reservations', 'user_id', 'shop_id')
                    ->as('content')
                    ->withPivot('id', 'date', 'time', 'number', 'payment');
    }
    public function reviews() {
        return $this->belongsToMany('App\Models\Shop', 'reviews', 'user_id', 'shop_id')
                    ->as('content')
                    ->withPivot('id', 'score', 'comment');
    }
}
