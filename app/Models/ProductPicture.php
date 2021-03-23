<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model 
{
    protected $table = 'product_pictures';

    protected $fillable = [ 
        'product_id',
        'picture_name',
    ];

    public function product() 
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}


?>