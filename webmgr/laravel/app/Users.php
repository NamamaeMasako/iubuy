<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $timestamps = true;
    protected $table   = 'users';

    //---------------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\Users);
    }
}
