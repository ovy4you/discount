### Features
Calculates discounts based on some rules created by the user.

## API Endpoint Discount : /api/discounts/calculate

## Documentation Discount Api


The discount rules are set in the table Order where a discount can be enabled or disabled.
I have created also a migration and seeder to create and populate the table.

We got 3 Discount Calculators in app/Repository/Discounts/ which are extending AbstractDiscountCalculator:

- CheapestProductDiscountCalculator
- FreeProductsDiscountCalculator
- TotalOrderDiscountCalculator

The controller app/Http/Controllers/Api/DiscountController uses a class app/Repository/Discounts/ChainDiscountCalculator which contains an array with the discounts calculator and loops over them stopping at the first discount it encounters.

The response contains the customerId the discount amount and a message(can be returned in various languages)

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.


