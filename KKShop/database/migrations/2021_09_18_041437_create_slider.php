<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Slider', function (Blueprint $table) {
            $table->increments('slider_id');
            $table->string('slider_ten');
            $table->string('slider_hinhanh');
            $table->String('slider_mota');
            $table->integer('slider_trangthai');
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
        Schema::dropIfExists('Slider');
    }
}
