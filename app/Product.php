<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function user_product_list()
    {
        return $this->hasOne(user_product_list::class, 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    protected $fillable = ['category_id', 'name', 'desc', 'price', 'lat', 'lng', 'img_path'];
}
