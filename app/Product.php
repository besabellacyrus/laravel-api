<?php

namespace App;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $guarded = [];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100)
              ->sharpen(10);

        $this->addMediaConversion('square')
              ->width(480)
              ->height(480)
              ->sharpen(10);
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('product-banner')
            ->singleFile();

        $this
            ->addMediaCollection('product-thumbnail')
            ->singleFile();

        $this
            ->addMediaCollection('product-display')
            ->singleFile();

    }

    public function brand()
    {
        return $this->belongsTo('App\ProductBrand');
    }

    public function type()
    {
        return $this->belongsTo('App\ProductType');
    }

    public function category()
    {
        return $this->belongsTo('App\ProductCategory');
    }
}
