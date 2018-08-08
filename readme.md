### Features
Calculates discounts based on some rules created by the user.

## API Endpoint Discount : /api/discounts/calculate

## Documentation Discount 

The discounts rules are set in the table Discounts where a discount can be enabled or disabled.
I have created also a migration and seeder to create and populate the table.

The discount calculators are located in app/Repository/Discounts/ which are extending AbstractDiscountCalculator:

- CheapestProductDiscountCalculator
- FreeProductsDiscountCalculator
- TotalOrderDiscountCalculator

The discounsts are chained in app/Repository/Discounts/ChainDiscountCalculator which is looping over them stopping at the first discount it encounters.

The controller app/Http/Controllers/Api/DiscountController return a response contains the customerId the discount amount and a message(can be returned in various languages)

Unit tests are made in : tests\Unit\DiscountTest.php
Functional test are made in  tests\Feature\DiscountTest.php




