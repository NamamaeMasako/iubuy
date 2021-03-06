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
        return $this->belongsTo('App\Members','members_account');
    }

    public function Products()
    {
        return $this->hasMany('App\Products','shops_id');
    }
}
