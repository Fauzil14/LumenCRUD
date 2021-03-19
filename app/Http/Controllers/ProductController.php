<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function index() 
    {
        $products = Product::get();
        $products->each->setAppends(['category_name']);

        return response()->json($products);
    }

    
}
