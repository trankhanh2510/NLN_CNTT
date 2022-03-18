<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AnhSanPham', function (Blueprint $table) {
            $table->increments('asp_id');
            $table->String('asp_ten');
            $table->String('asp_hinhanh');
            $table->integer('sp_id');
            $table->integer('asp_trangthai');
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
        Schema::dropIfExists('AnhSanPham');
    }
}
