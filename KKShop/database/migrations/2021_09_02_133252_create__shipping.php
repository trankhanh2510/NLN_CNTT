<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Shipping', function (Blueprint $table) {
            $table->increments('shipping_id');
            $table->integer('kh_id');
            $table->string('shipping_ten');
            $table->string('shipping_diachi');
            $table->String('shipping_sdt');
            $table->String('shipping_note');
             $table->integer('phi');
            $table->integer('shipping_trangthai');
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
        Schema::dropIfExists('Shipping');
    }
}
