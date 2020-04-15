<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductMediaController extends Controller
{
    public function singleImage (Product $product, Request $request)
    {
        $singleProduct = $product::where('id', '=', $request->product_id);
        try {
            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                $upload = $singleProduct->addMediaFromRequest('thumbnail')->toMediaCollection('product-thumbnails');
                return response([ 'message' => $upload, 'product' => singleProduct]);

            } else {
                return response([ 'message' => 'wala' ]);
            }
            // if($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()){
            //     $upload = $product->addMediaFromRequest('thumbnail')->toMediaCollection('product-thumbnails');
            //     dd($upload);
            // }
        } catch (\Exception $e) {
            //throw $th;
            return $e->getMessage();
        }
        // return $request->all();
    }
}
