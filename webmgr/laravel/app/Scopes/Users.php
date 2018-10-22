<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Users implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->select(DB::raw("
        	*,
            CASE Users.admin WHEN 1 THEN '一般' WHEN 0 THEN '最高' END as text_admin
            "
            ));
    }
}