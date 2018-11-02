<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productlists extends Model
{
    public $timestamps = true;
    protected $table   = 'product_lists';

    //---------------------------------------------------------------------------------

    public function Products()
    {
        return $this->belongsTo('App\Products','products_id');
    }

    public function Shops()
    {
        return $this->belongsTo('App\Shops','shops_id');
    }
}
