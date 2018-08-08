<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function getDiscountRulesAttribute($value)
    {
        return json_decode($value);
    }

    public static function sqlQuery($discountType)
    {
        $where[] =  ['discount_type', '=', $discountType];
        $where[] =  ['active', '=', '1'];

        return self::where($where);
    }
}
