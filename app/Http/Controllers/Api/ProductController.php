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
    return Product::find($id);
  }

  public function store(Request $request)
  {
      $validatedData = $request->validate([
          'product_code' => 'required',
          'product_name' => 'required',
          'product_title' => 'required',
          'date_arrived' => 'required',
          'expiry_date' => 'required',
          // 'description' => 'required|max:255',
          // 'specs' => 'sometimes|max:500',
          // 'memo' => 'sometimes|max:255',
          // 'pcs_per_carton' => 'required',
          // 'weight' => 'required',
          // 'qty' => 'sometimes',
          // 'type_id' => 'sometimes|required',
          // 'brand_id' => 'sometimes|required',
          // 'category_id' => 'sometimes|required',
          // 'profile' => 'sometimes|required'
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
}
