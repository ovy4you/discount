<?php
/**
 * Calculate a discount based on a percent from the total amount if the clients reaches a specific total threshold
 */

namespace App\Repository\Discounts;

use App\Discount;

class CheapestProductDiscountCalculator extends AbstractDiscountCalculator
{
    const DISCOUNT_CHEAPEST_PRODUCT = 3;

    /**
     * @param $order
     * @return $this
     */
    public function getDiscountInfo($order)
    {
        $this->order = $order;

        $discounts = Discount::sqlQuery(self::DISCOUNT_CHEAPEST_PRODUCT)->first();
        if ($discounts) {
            $countItems = array_sum(array_column($this->order['items'], 'quantity'));
            foreach ($discounts->discount_rules as $rule) {
                if ($rule->category_id == $this->order['id'] && $countItems >= $rule->minium_order_products) {
                    $this->discount = $this->getPriceCheapestProduct() * $rule->discount_amount / 100;
                    $this->discountType = self::DISCOUNT_CHEAPEST_PRODUCT;
                }
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    private function getPriceCheapestProduct()
    {
        return min(array_column($this->order['items'], 'unit-price'));
    }
}
