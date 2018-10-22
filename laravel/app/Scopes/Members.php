<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use DB;

class Members implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->select(DB::raw("
        	*,
        	CASE Members.admin WHEN 1 THEN '高級' WHEN 0 THEN '一般' END as text_admin,
            CASE Members.premission WHEN 1 THEN '開放' WHEN 0 THEN '停權' END as text_premission
            "
            ));
    }
}