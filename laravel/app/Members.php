<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->hasMany('App\Shops','members_account');
    }

    public function Employees()
    {
        return $this->hasMany('App\Employees','members_account');
    }

    public function MemberProfiles()
    {
        return $this->hasOne('App\MemberProfiles','members_account');
    }
}
