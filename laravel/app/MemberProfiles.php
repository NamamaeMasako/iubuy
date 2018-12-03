<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MemberProfiles extends Model
{
    public $timestamps = true;
    protected $table   = 'members_profile';

    public function Members()
    {
        return $this->belongsTo('App\Members','members_account');
    }
}
