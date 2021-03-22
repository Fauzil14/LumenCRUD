<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'product_code'  => 'required|unique:products,product_code',
            'category_id'   => 'required|exists:categories,id',
            'stock'         => 'required|integer',
            'pic_one'       => 'nullable',
            'pic_two'       => 'nullable',
            'pic_three'     => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            
            $product = new Product;
            $product->product_code  = $request->product_code;
            $product->brand         = $request->brand;        
            $product->product_name  = $request->product_name;
            $product->category_id   = $request->category_id;
            $product->stock         = $request->stock;
            if($request->filled('pic_one') && $request->file('pic_one')) {
                $url_one = $this->storeProductPic($request->file('pic_one'), $request->product_code);
                $product->pic_one       = $url_one;
            }
            if($request->filled('pic_two') && $request->file('pic_two')) {
                $url_two = $this->storeProductPic($request->file('pic_two'), $request->product_code);
                $product->pic_two       = $url_two;
            }
            if($request->filled('pic_three') && $request->file('pic_three')) {
                $url_three = $this->storeProductPic($request->file('pic_three'), $request->product_code);
                $product->pic_three     = $url_three;
            }
            $product->save();
        
            DB::commit();
            return response()->json($product);
        } catch(\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to make product',
                'error' => $th->getMessage()
            ], 500);
        }

    }

    public function storeProductPic($file, $product_code)
    {
        $name = time() . '.' . $file->getClientOriginalName();
        $directory = storage_path('app/public'). '/' . $product_code;
        $file->move($directory, $name);
        $url = URL::asset('storage/' . $product_code . '/' . $name);
        return $url;
    }

}
