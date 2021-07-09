<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->foreignId('country_id');
            $table->foreignId('city_id');
            $table->foreignId('state_id');
            $table->string('zipcode');
            $table->string('cupon')->nullable();
            $table->string('tottal_price')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_type');
            $table->string('payment_status')->default(1)->comment('1=pending 2=paid');
            $table->string('product_status')->default(1)->comment('1=pending 2=relase 3=on the way 4=completed');
            $table->string('different_shipping')->default(1)->comment('1=no shipping 2=yes shipping');
            $table->softDeletes();
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
        Schema::dropIfExists('billings');
    }
}
