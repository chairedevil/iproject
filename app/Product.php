<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function user_product_lists()
    {
        return $this->hasMany(user_product_list::class, 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
