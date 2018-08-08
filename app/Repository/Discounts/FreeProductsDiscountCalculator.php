<?php
/**
 * Calculate the discount based on the number of product/s you get for free from a category when you order a specific number form that category
 */

namespace App\Repository\Discounts;

use App\Discount;

class FreeProductsDiscountCalculator extends AbstractDiscountCalculator
{

    const DISCOUNT_FREE_PRODUCT = 2;

    /**
     * @param $order
     * @return $this
     */
    public function getDiscountInfo($order)
    {
        $this->order = $order;

        $discounts = Discount::sqlQuery(self::DISCOUNT_FREE_PRODUCT)->first();
        if ($discounts) {
            foreach ($discounts->discount_rules as $rule) {
                if ($rule->category_id == $this->order['id']) {
                    foreach ($this->order['items'] as $item) {
                        $getNoFreeProducts = intval($item['quantity'] / $rule->minimum_order_products);
                        $this->discount += $getNoFreeProducts * $item['unit-price'] * $rule->discount_products;
                    }
                }
            }

            $this->discountType = self::DISCOUNT_FREE_PRODUCT;
        }
        return $this;
    }
}
