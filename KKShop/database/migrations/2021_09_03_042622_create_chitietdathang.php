<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitietdathang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ChiTietDatHang', function (Blueprint $table) {
            $table->increments('ctdh_id');
            $table->integer('dh_id');
            $table->integer('sp_id');
            $table->String('sp_ten');
            $table->integer('sp_gia');
            $table->integer('ctdh_soluong');
            $table->integer('ctdh_dongia');
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
        Schema::dropIfExists('ChiTietDatHang');
    }
}
