<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps = true;
    protected $table   = 'products';

    //---------------------------------------------------------------------------------

    public function ProductLists()
    {
        return $this->hasMany('App\Product_lists','products_id');
    }

}
