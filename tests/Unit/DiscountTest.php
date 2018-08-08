<?php

namespace Tests\Unit;

use App\Discount;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repository\Discounts\{
    TotalOrderDiscountCalculator, ChainDiscountCalculator
};

class DiscountTest extends TestCase
{
    use DatabaseMigrations;


    public $discountCalculators;

    public function setUp()
    {
        parent::setUp(); //

        $this->artisan('db:seed');

        $chainDiscountCalculator = new ChainDiscountCalculator;

        foreach (config('discount') as $discountCalculator) {
            $chainDiscountCalculator->addDiscountCalculator($discountCalculator);
        }

        $this->discountCalculators = $chainDiscountCalculator;

    }

    public function testDiscountId()
    {
        $discount = factory(Discount::class)->make();

        $this->assertEquals(TotalOrderDiscountCalculator::DISCOUNT_TOTAL_ORDER, $discount->discount_type);
    }


    public function testDiscountNoDiscount()
    {
        $request = json_decode('{
                      "id": "2",
                      "customer-id": "3",
                      "items": [
                        {
                          "product-id": "A101",
                          "quantity": "1",
                          "unit-price": "9.75",
                          "total": "19.50"
                        },
                        {
                          "product-id": "A102",
                          "quantity": "1",
                          "unit-price": "49.50",
                          "total": "49.50"
                        }
                      ],
                      "total": "999.00"
                   }', true);


        $this->assertEquals($this->discountCalculators->runDiscount($request)['discount'], 0);
    }


    public function testDiscountTotalOrder()
    {
        $request = json_decode('{
                      "id": "1",
                      "customer-id": "1",
                      "items": [
                        {
                          "product-id": "A101",
                          "quantity": "1",
                          "unit-price": "9.75",
                          "total": "500.00"
                        },
                        {
                          "product-id": "A102",
                          "quantity": "1",
                          "unit-price": "49.50",
                          "total": "500.00"
                        }
                      ],
                      "total": "1000.00"
                   }', true);


        $this->assertEquals($this->discountCalculators->runDiscount($request)['discount'], 100);
    }


    public function testFreeProductOrder()
    {
        $request = json_decode('{
                      "id": "2",
                      "customer-id": "1",
                      "items": [
                        {
                          "product-id": "A101",
                          "quantity": "6",
                          "unit-price": "10",
                          "total": "60.00"
                        },
                        {
                          "product-id": "A102",
                          "quantity": "6",
                          "unit-price": "10",
                          "total": "60.00"
                        }
                      ],
                      "total": "120.00"
                   }', true);


        $this->assertEquals($this->discountCalculators->runDiscount($request)['discount'], 20);
    }


    public function testCheapestProductOrder()
    {
        $request = json_decode('{
                      "id": "1",
                      "customer-id": "1",
                      "items": [
                        {
                          "product-id": "A101",
                          "quantity": "2",
                          "unit-price": "20",
                          "total": "500.00"
                        },
                        {
                          "product-id": "A102",
                          "quantity": "2",
                          "unit-price": "10",
                          "total": "500.00"
                        }
                      ],
                      "total": "60.00"
                   }', true);


        $this->assertEquals($this->discountCalculators->runDiscount($request)['discount'], 2);
    }

}
