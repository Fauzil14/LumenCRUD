<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'product_code',
        'brand',
        'product_name',
        'category_id',
        'stock',
    ];

    protected $appends = [];

    public function getCategoryNameAttribute() {
        return $this->category()->first()->category_name;
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function productPicture() 
    {
        return $this->hasMany(ProductPicture::class, 'product_id', 'id');
    }

}
