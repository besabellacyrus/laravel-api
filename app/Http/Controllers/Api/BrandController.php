<?php

namespace App\Http\Controllers\Api;

use App\ProductBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
  public function index()
  {
    return ProductBrand::all();
  }

  public function show($id)
  {
    return ProductBrand::find($id);
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'description' => 'required',
    ]);

    $brand = ProductBrand::create($validatedData);

    return response(['brand' => $brand, 'status' => 'created']);
  }

  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'name' => 'required|max:255',
      'description' => 'required|max:255'
    ]);

    ProductBrand::whereId($id)->update($request->all());
    return response(['status' => 'updated']);
  }

}
