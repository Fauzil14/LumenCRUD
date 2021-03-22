<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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

    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);

        return response()->json($product);
    }

    public function create(Request $request) 
    {
        $this->validate($request, [
            'product_code'  => 'required',
            'brand'         => 'required|string|max:10',        
            'product_code'  => 'required',
            'category_id'   => 'required|exists:categories,id',
            'stock'         => 'required|integer',
            'pic_one'       => 'required',
            'pic_two'       => 'nullable',
            'pic_three'     => 'nullable',
        ]);

        // try {
            $product = new Product;
            $product->product_code  = $request->product_code;
            $product->brand         = $request->brand;        
            $product->product_name  = $request->product_name;
            $product->category_id   = $request->category_id;
            $product->stock         = $request->stock;
            if($request->file('pic_one')->isValid()) {
                $name = time() . '.' . $request->file('pic_one')->getClientOriginalName();
                $directory = storage_path('app/public'). '/' . $request->product_code;
                $request->file('pic_one')->move($directory, $name);
                $url = URL::asset('storage/' . $request->product_code . '/' . $name);
                return response()->json($url);
            }
        
        // }

    }

}
