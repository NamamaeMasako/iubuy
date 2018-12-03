<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Shops implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->select(DB::raw("
        	*,
            CASE Shops.status WHEN 2 THEN '停業中' WHEN 1 THEN '營業中' WHEN 0 THEN '休息中' END as text_status
            "
            ));
    }
}