<?php
/**
 * Created by PhpStorm.
 * User: gciuca
 * Date: 09.07.2018
 * Time: 13:09
 */

namespace App\Repository\Discounts;

abstract class AbstractDiscountCalculator
{
    protected $order = [];
    protected $discount = 0;
    protected $discountType;

    const DISCOUNT_NO_DISCOUNT = 0;

    abstract public function getDiscountInfo($order);

    /**
     * @return array
     */
    public function response()
    {
        return [
            'customer-id' => $this->order['customer-id'],
            'discount' => $this->discount,
            'discount_type' => trans_choice('general.order_discount', $this->discountType),
        ];
    }

    /**
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }


    public function getDiscountType()
    {
        return $this->discountType;
    }
}
