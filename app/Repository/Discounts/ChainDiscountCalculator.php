<?php

namespace App\Repository\Discounts;


class ChainDiscountCalculator
{
    private $discounts = [];

    public function addDiscountCalculator($cmd)
    {
        $this->discounts [] = $cmd;
    }

    /**
     * @param $order
     * @return mixed
     */
    public function runDiscount($order)
    {
        /**
         * Return first discount applicable in the order of priority
         */
        foreach ($this->discounts as $discount) {
            if (class_exists($discount)) {
                $discountInfo = (new $discount)->getDiscountInfo($order);

                if ($discountInfo->response()['discount']) {
                    return $discountInfo->response();
                }
            } else {
                throw new \Exception('Calculator doesn\'t exist');
            }
        }

        /**
         * Return no discount applicable
         */
        return (new class extends AbstractDiscountCalculator
        {
            public function getDiscountInfo($order)
            {
                $this->order = $order;
                $this->discountType = AbstractDiscountCalculator::DISCOUNT_NO_DISCOUNT;
                return $this;
            }
        })->getDiscountInfo($order)->response();

    }
}
