<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductMedia;
use Illuminate\Support\Collection;
use Str;
use Spatie\MediaLibrary\MediaStream;
use Spatie\MediaLibrary\Models\Media;
class ProductController extends Controller
{
  public function index()
  {

    $products = Product::all();
    foreach ($products as $product) {
      $product->getMedia();
    }
    return $products;
  }

  public function show($id)
  {
    $product = Product::find($id);
    $product->media = $product->getMedia();
    return response(['data' => $product ]);
  }

  public function getMedia($id)
  {
    $product = Product::find($id);
    try {
      // $stack = [];
      $product->media = $product->getMedia();
      // $product->thumbnail = $product->getMedia('product-thumbnail');
      return response(['product' => $product ]);
    } catch (Exception $e) {
      return response(['message' => $e ]);
    }
  }

  public function store(Request $request)
  {
      $validatedData = $request->validate([
          'product_code' => 'required',
          'product_name' => 'required',
          'product_title' => 'required'
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

  public function downloadMedia($id)
   {
        // Let's get some media.
        $product = Product::find($id);
        $downloads = $product->getMedia();

        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create($product->product_code.'.zip')->addMedia(Media::all());
   }

  public function singleImage (Request $request)
  {
      $singleProduct = Product::find($request->product_id);

      try {
          if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
              $upload = $singleProduct->addMediaFromRequest('thumbnail')->toMediaCollection('product-thumbnails');

              // find the image
              $mediaItems = $singleProduct->getMedia('product-thumbnails');
              // $count = count($mediaItems) -1;
              $thumb = $mediaItems[$count]->getUrl('square');

              $singleProduct->profile = $thumb;
              $singleProduct->save();

              return response([ 'message' => $upload, 'product' => $singleProduct, 'thumb' => $thumb]);

          } else {
              return response([ 'message' => 'wala' ]);
          }
      } catch (\Exception $e) {
          //throw $th;
          return $e->getMessage();
      }
  }

  public function multipleImage (Request $request)
  {
    try {
      $product = Product::find($request->product_id);

      $imageTypes = $request->image_types;
      $uploadedImages = [];
      if($request->TotalImages > 0) {
        for ($x = 0; $x < $request->TotalImages; $x++) {
          $mediaCollection = "";

          switch ($imageTypes[$x] ) {
            case 'banner':
              $mediaCollection = 'product-banner';
              break;
            case 'display':
              $mediaCollection = 'product-display';
              break;
            case 'thumbnail':
              $mediaCollection = 'product-thumbnail';
              break;
            default:
              $mediaCollection = 'product-images';
              break;
          }

          if ($request->hasFile('images'.$x)) {
            $uploaded = $product->addMediaFromRequest('images'.$x)->toMediaCollection($mediaCollection);
            array_push($uploadedImages, $uploaded);
          }
        }
      }

      return response(['uploaded' => true, 'files' => $uploadedImages]);

    } catch (\Exception $e) {
      // return $e->getMessage();
      return response(['uploaded' => false]);
    }
  }

  public function singleUpload(Request $request)
  {
    try {
      $product = Product::find($request->product_id);

      $imageCollection = $request->collection;

      if ($request->hasFile('file')) {
        $uploaded = $product->addMediaFromRequest('file')->toMediaCollection($imageCollection);
      }

      return response(['uploaded' => true, 'file' => $uploaded ]);

    } catch (\Exception $e) {
      // return $e->getMessage();
      return response(['uploaded' => false]);
    }
  }

  public function deleteMedia (Request $request)
  {
    try {
      $product = Product::find($request->product_id);
      $imageId = $request->image_id;
      $mediaItems = $product->getMedia($request->collection_name);
      $deletethis = [];

      $d = json_decode($mediaItems);
      foreach ($d as $value) {
        if ($value->id === (int)$imageId) {
          $key = array_search($value, $d);
          $mediaItems[$key]->delete();
          return response(['delete' => true, 'product' => $product ]);
        }
      }

      return response(['delete' => false, $product ]);

    } catch (\Exception $e) {
      return response([
        'delete' => false,
        'message' => $e,
        'image_id' => $request->image_id
      ]);
    }
  }
}
