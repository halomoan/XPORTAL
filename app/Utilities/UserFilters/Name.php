<?php

namespace App\Utilities\UserFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;

class Name extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('name', 'like', '%' . $value . '%');
    }
}
