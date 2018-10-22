<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    public $timestamps = true;
    protected $table   = 'members';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Members);
    }

    //---------------------------------------------------------------------------------

    public function Shops()
    {
        return $this->hasMany('App\Shops','members_id');
    }

    public function Employees()
    {
        return $this->hasMany('App\Employees','members_id');
    }
}
