<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Products implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->select(DB::raw("
        	*,
            CASE Products.checked WHEN 0 THEN '禁賣' WHEN 1 THEN '省略' WHEN 2 THEN '合格' END as text_checked
            "
        ));
    }
}