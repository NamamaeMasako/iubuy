<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productlists extends Model
{
    public $timestamps = true;
    protected $table   = 'product_lists';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Productlists);
    }

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
