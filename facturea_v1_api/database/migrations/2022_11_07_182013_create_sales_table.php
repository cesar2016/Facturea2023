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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->integer('indentificator_sale');
            $table->dateTime('date_sale');
            $table->integer('cuantity');
            $table->integer('unit_price');
            $table->integer('total_price');

            $table->foreignId('client_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('type_sale_id')->constrained();

            $table->string('status');

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
        Schema::dropIfExists('sales');
    }
};
