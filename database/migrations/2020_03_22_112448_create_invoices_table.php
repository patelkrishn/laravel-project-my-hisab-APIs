<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->bigInteger('payment_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('seller_id');
            $table->bigInteger('product_id');
            $table->bigInteger('invoice_quantity');
            $table->double('product_price');
            $table->double('total_amount');
            $table->double('total_payable_amount');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('invoices');
    }
}
