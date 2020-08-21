<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class QueryCollection
{
    public static function firstPeriodSum($period, $manCode)
    {
        if (is_null($manCode)) {
            $name = '*';
        }
    }
}
