<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Schema;


class StringFilter
{
    public function handle($query, $next, $column,$table,$filterOR = "false") {


        $fieldname = substr($column, 1);
        if( Schema::hasColumn($table, $fieldname) === false)
        {
            return $next($query);
        }

        if (request()->{$column}) {
            if ($filterOR === "true") {
                $query->OrWhere($fieldname, 'LIKE', '%'.request()->{$column} .'%');
            } else {
                $query->where($fieldname, 'LIKE', '%'.request()->{$column} .'%');
            }
        }

         return $next($query);

    }
}
