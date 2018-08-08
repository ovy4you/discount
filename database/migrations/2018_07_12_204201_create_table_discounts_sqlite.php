<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDiscountsSqlite extends Migration
{


    protected $connection = 'sqlite';


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('sqlite')->hasTable('discounts')) {
            Schema::connection('sqlite')->create('discounts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('discount_type')->nullable(false);
                $table->json('discount_rules');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlite')->dropIfExists('discount');
    }
}
