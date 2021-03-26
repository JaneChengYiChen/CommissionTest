<?php

namespace App\Commission;

class CommissionDB
{
    const ST_PKS = 'stPKS';
    const ST_CORE = 'stCore';

    private static $db = [
        CommissionDB::ST_PKS => CommissionDB::ST_PKS,
        CommissionDB::ST_CORE => CommissionDB::ST_CORE
    ];

    public static function dbInit($name)
    {
        try {
            return \DB::connection(self::$db[$name]);
        } catch (\Exception $e) {
            return response()->json($e, 200);
        }
    }
}
