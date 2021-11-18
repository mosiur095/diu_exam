<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('version')->unsigned();
            $table->integer('class')->unsigned();
            $table->integer('subject')->unsigned();
            $table->integer('quiz')->unsigned();
            $table->foreign('version')->references('id')->on('virson')->onDelete('cascade');
            $table->foreign('class')->references('id')->on('class')->onDelete('cascade');
            $table->foreign('subject')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('quiz')->references('id')->on('quiz')->onDelete('cascade');
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
        Schema::dropIfExists('card');
    }
}
