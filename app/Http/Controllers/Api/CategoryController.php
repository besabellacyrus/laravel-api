<?php

namespace App\Http\Controllers\Api;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function index()
  {
    return ProductCategory::all();
  }

  public function show($id)
  {
    return ProductCategory::find($id);
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'description' => 'required',
    ]);

    $category = ProductCategory::create($validatedData);

    return response(['category' => $category, 'status' => 'created']);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required',
      'description' => 'required'
    ]);

    $update = ['name' => $request->name, 'description' => $request->description];
    ProductCategory::where('id',$id)->update($update);
  }

}
