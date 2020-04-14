<?php

namespace App\Http\Controllers\Api;

use App\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
  public function index()
  {
    return ProductType::all();
  }

  public function show($id)
  {
    return ProductType::find($id);
  }

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required',
      'description' => 'required',
    ]);

    $type = ProductType::create($validatedData);

    return response(['type' => $type, 'status' => 'created']);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required',
      'description' => 'required'
    ]);

    $update = ['name' => $request->name, 'description' => $request->description];
    ProductType::where('id',$id)->update($update);
  }

}
