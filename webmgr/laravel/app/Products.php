<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps = true;
    protected $table   = 'products';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Products);
    }

    //---------------------------------------------------------------------------------

    public function Shops()
    {
        return $this->belongsTo('App\Shops','shops_id');
    }

    public function Productlists()
    {
        return $this->hasMany('App\Productlists','products_id');
    }
}
