<?php
/**
 * Calculate a discount based on a percent from the total amount if the clients reaches a specific total threshold
 */

namespace App\Repository\Discounts;

use App\Discount as Discount;

class TotalOrderDiscountCalculator extends AbstractDiscountCalculator
{


    const DISCOUNT_TOTAL_ORDER = 1;

    /**
     * @param $order
     * @return $this
     */
    public function getDiscountInfo($order)
    {
        $discounts = Discount::sqlQuery(self::DISCOUNT_TOTAL_ORDER)->first();
        $this->order = $order;

        if ($discounts) {
            foreach ($discounts->discount_rules as $rule) {
                if ($rule->minimum_order_amount <= $this->order['total']) {
                    $this->discount = $this->order['total'] * $rule->discount_amount / 100;
                    break;
                }
            }
            $this->discountType = self::DISCOUNT_TOTAL_ORDER;
        }
        return $this;
    }
}
