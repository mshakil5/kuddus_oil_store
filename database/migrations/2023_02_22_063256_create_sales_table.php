<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
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
            $table->string('date',191)->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('product_id',191)->nullable();
            $table->string('invoiceno',191)->nullable();
            $table->string('company',191)->nullable();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('car_number',191)->nullable();
            $table->string('product_take',191)->nullable();
            $table->double('price_per_unit',10,2)->nullable();
            $table->string('quantity',191)->nullable();
            $table->double('amount',10,2)->nullable();
            $table->double('cash_rcv',10,2)->nullable();
            $table->double('due',10,2)->nullable();
            $table->double('net_amount',10,2)->nullable();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(0);
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
}
