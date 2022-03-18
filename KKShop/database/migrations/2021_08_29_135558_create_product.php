<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SanPham', function (Blueprint $table) {
            $table->increments('sp_id');
            $table->string('sp_Ten');
            $table->integer('l_id');
            $table->integer('th_id');
            $table->text('sp_MoTa');
            $table->text('sp_noidung');
            $table->integer('sp_gia');
            // $table->string('sp_hinhanh');
            $table->integer('sp_soluong');
            $table->integer('sp_TrangThai');
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
        Schema::dropIfExists('SanPham');
    }
}
