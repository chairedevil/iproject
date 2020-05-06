<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function chats_sender()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function chats_receiver()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user_product_list_buyer()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    public function user_product_list_seller()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
