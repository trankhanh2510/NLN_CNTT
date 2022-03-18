<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDathang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DatHang', function (Blueprint $table) {
            $table->increments('dh_id');
            $table->integer('shipping_id');
            $table->integer('dh_tongtien');
            $table->integer('dh_phi_vc');
            $table->integer('dh_tongdh');
            $table->integer('dh_trangthai');
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
        Schema::dropIfExists('DatHang');
    }
}
