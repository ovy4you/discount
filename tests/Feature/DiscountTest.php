<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DiscountTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }


    public function testNoDiscount()
    {
        $request = [
            "id" => "7",
            "customer-id" => "3",
            "items" => [
                [
                    "product-id" => "A101",
                    "quantity" => "2",
                    "unit-price" => "9.75",
                    "total" => "19.50"
                ],
                [
                    "product-id" => "A102",
                    "quantity" => "9",
                    "unit-price" => "49.50",
                    "total" => "49.50"
                ]
            ],
            "total" => "69.00"
        ];

        $response = $this->json('post', '/api/discounts/calculate', $request);

        $this->assertEquals(
            $response->json(),
            [
                "customer-id" => "3",
                "discount" => 0,
                "discount_type" => "No discounts",
            ]
        );
    }


    public function testDiscountTotalOrder()
    {
        $request = [
            "id" => "3",
            "customer-id" => "3",
            "items" => [
                [
                    "product-id" => "A101",
                    "quantity" => "2",
                    "unit-price" => "9.75",
                    "total" => "19.50"
                ],
                [
                    "product-id" => "A102",
                    "quantity" => "9",
                    "unit-price" => "49.50",
                    "total" => "49.50"
                ]
            ],
            "total" => "1169.00"
        ];

        $response = $this->json('post', '/api/discounts/calculate', $request);

        $this->assertEquals(
            $response->json(),
            [
                "customer-id" => "3",
                "discount" => 116.9,
                "discount_type" => "discount on the whole order",
            ]
        );
    }

    public function testBadRequest()
    {
        $request = [
            "customer-id" => "3",
            "items" => [
                [
                    "product-id" => "A101",
                    "quantity" => "2",
                    "unit-price" => "9.75",
                    "total" => "19.50"
                ],
                [
                    "product-id" => "A102",
                    "quantity" => "9",
                    "unit-price" => "49.50",
                    "total" => "49.50"
                ]
            ],
            "total" => "69.00"
        ];
        $response = $this->json('post', '/api/discounts/calculate', $request);

        $this->assertEquals($response->json(), ["message" => ["id" => ["The id field is required."]]]);
    }
}
