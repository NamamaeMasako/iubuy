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
            CASE Shops.premission WHEN 2 THEN '營業' WHEN 1 THEN '休息' WHEN 0 THEN '禁賣' END as text_premission
            "
            ));
    }
}