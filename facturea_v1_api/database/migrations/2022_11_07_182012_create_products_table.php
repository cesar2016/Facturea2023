<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->integer('stock');
            $table->integer('price_purchase');
            $table->integer('price_sale');
            $table->string('status')->default(1);
            $table->date('date_purchase');

            /*$table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');*/

            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_product_id')->constrained();
            //$table->foreignId('provider_id')->constrained();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
