<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

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
