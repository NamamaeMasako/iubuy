<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    public $timestamps = true;
    protected $table   = 'shops';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Shops);
    }

    //---------------------------------------------------------------------------------

    public function Members()
    {
        return $this->belongsTo('App\Members','id');
    }

    public function Employees()
    {
        return $this->hasMany('App\Employees','shops_id');
    }

    public function Product_lists()
    {
        return $this->hasMany('App\Productlists','shops_id');
    }
}
