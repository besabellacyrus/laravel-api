<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  public function index()
  {
    return datatables()->of(Product::all())
        ->addColumn('action', 'action_button')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
  }

  public function show($id)
  {
    $product = Product::find($id);
    $thumb = $product->getFirstMediaUrl('product-thumbnails', 'thumb');
    return response(['data' => $product, 'thumbnail' => $thumb ]);
  }

  public function store(Request $request)
  {
      $validatedData = $request->validate([
          'product_code' => 'required',
          'product_name' => 'required',
          'product_title' => 'required',
          'date_arrived' => 'required',
          'expiry_date' => 'required',
      ]);

      $product = Product::create($request->all());

      return response(['product' => $product, 'status' => 'created']);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'product_code' => 'sometimes|required',
      'product_name' => 'sometimes|required',
      'product_title' => 'sometimes|required',
    ]);

    Product::whereId($id)->update($request->all());
    return response(['status' => 'updated']);
  }

  public function destroy($id)
  {
    Product::where('id',$id)->destroy();
    return response(['status' => 'deleted']);
  }

  public function deleteMany(Request $request)
  {
     try {
      Product::whereIn('id', $request->id)->delete(); // $request->id MUST be an array
      return response(['status' => 'deleted']);
     } catch (Exception $e) {
      return response(['message' => 'Something went wrong.']);
     }
  }

  public function singleImage (Request $request)
  {
      $singleProduct = Product::find($request->product_id);

      try {
          if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
              $upload = $singleProduct->addMediaFromRequest('thumbnail')->toMediaCollection('product-thumbnails');
              return response([ 'message' => $upload, 'product' => $singleProduct]);

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
  }
}
