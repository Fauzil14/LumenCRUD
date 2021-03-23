<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductPicture;
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

        return response()->json($products->load('productPicture'));
    }

    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);

        return response()->json($product);
    }

    public function create(Request $request) 
    {
        $validated = $this->validate($request, [
            'product_code'  => 'required',
            'brand'         => 'required|string|max:10',        
            'product_code'  => 'required|unique:products,product_code',
            'category_id'   => 'required|exists:categories,id',
            'stock'         => 'required|integer',
            'pictures.*'    => 'nullable|image',
        ]);

        try {
            DB::beginTransaction();
         
            $product = Product::create($request->except('pictures'));

            if($request->hasFile('pictures')) {
                foreach($request->file('pictures') as $picture) {
                    $url['picture_name'] = $this->storeProductPic($picture, $request->product_code);
                    $product->productPicture()->create($url);
                }
            }
    
            DB::commit();
            return response()->json($product->load('productPicture'));
        } catch(\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to make product',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $product_id) 
    {
        $this->validate($request, [
            'product_code'       => 'nullable',
            'brand'              => 'nullable|string|max:10',        
            'product_code'       => 'nullable',
            'category_id'        => 'nullable|exists:categories,id',
            'stock'              => 'nullable|integer',
            'pictures'           => 'nullable',
            'pictures.*.id'      => 'required_if:pictures,!=,null|exists:product_pictures,id',
            'pictures.*.picture' => 'required_if:pictures,!=,null|image',
        ]);

        try {
            DB::beginTransaction();
         
            $product = Product::findOrFail($product_id);

            $update = array_filter($request->except('pictures', '_method'));
            $product->update($update);

            if($request->filled('pictures')) {
                foreach($request->pictures as $picture) {
                    $image = $product->productPicture()->where('id', $picture['id'])->first();
                    if( !empty($image) ) {
                        $filename = explode('/', $image->picture_name);
                        $image_path = rtrim(app()->basePath('public/storage'), '/') . '/' . $product->product_code . '/' . end($filename);
                        unlink($image_path);
                    }
                    $url['picture_name'] = $this->storeProductPic($picture['picture'], !is_null($request->product_code) ? $request->product_code : $product->product_code);
                    $product->productPicture()->where('id', $picture['id'])->update($url);
                }
            }
    
            DB::commit();
            return response()->json($product->load('productPicture'));
        } catch(\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to update product',
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

    public function delete($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $images = $product->productPicture()->pluck('picture_name');
 
            if( count($images) > 0 ) {
                foreach($images as $image) {
                    $filename = explode('/', $image);
                    $image_path = rtrim(app()->basePath('public/storage'), '/') . '/' . $product->product_code . '/' . end($filename);
                    unlink($image_path);
                }
            }
            $product->delete();

            return response()->json([
                'message' => 'Product successfully deleted',
            ], 200);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Failed to delete product',
                'error' => $th->getMessage()
            ], 500);
        }
    }

}
