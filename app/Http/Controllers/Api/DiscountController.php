<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repository\Discounts\{FreeProductsDiscountCalculator,TotalOrderDiscountCalculator,CheapestProductDiscountCalculator,ChainDiscountCalculator};
use App\Http\Controllers\Controller;

use Validator;

class DiscountController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        $rules = [
            'id' => 'numeric|required',
            'total' => 'numeric|required',
            'customer-id' => 'numeric|required',
            'items' => 'array|required',
            'items.*.total'=> 'numeric|required',
            'items.*.unit-price'=> 'numeric|required',
            'items.*.quantity'=> 'numeric|required',
            'items.*.product-id'=> 'alphanum|required',
        ];

        $validator = Validator::make($request->json()->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 404);
        }

        $discountCalculators = config('discount');

        $chainDiscountCalculator = new ChainDiscountCalculator;

        foreach ($discountCalculators as $discountCalculator){
            $chainDiscountCalculator->addDiscountCalculator($discountCalculator);
        }

        return $chainDiscountCalculator->runDiscount($request->json()->all());

    }
}
