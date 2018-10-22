<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $timestamps = true;
    protected $table   = 'employees';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Employees);
    }

    //---------------------------------------------------------------------------------

    public function Members()
    {
        return $this->belongsTo('App\Members','id');
    }

    public function Shops()
    {
        return $this->belongsTo('App\Shops','id');
    }
}
