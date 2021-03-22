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
        'pic_one',
        'pic_two',
        'pic_three',
    ];

    protected $appends = [];

    protected static function booted() 
    {
        static::creating(function($query) {
            if($query->pic_one == null) {
                $query->pic_one = url('/pictures/No_Image_Available.jpg');
            }
            if($query->pic_two == null) {
                $query->pic_two = url('/pictures/No_Image_Available.jpg');
            }
            if($query->pic_three == null) {
                $query->pic_three = url('/pictures/No_Image_Available.jpg');
            }
        });
    }    

    public function getCategoryNameAttribute() {
        return $this->category()->first()->category_name;
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
