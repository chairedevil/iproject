<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_product_list extends Model
{
    public function user_buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function user_seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'product_id');
    }

    protected $fillable = ['product_id', 'buyer_id', 'seller_id', 'status'];
}
