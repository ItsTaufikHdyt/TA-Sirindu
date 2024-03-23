<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_anak')->unsigned();
            $table->integer('hbo')->nullable();
            $table->integer('bcg')->nullable();
            $table->integer('polio1')->nullable();
            $table->integer('dpthb_hib1')->nullable();
            $table->integer('polio2')->nullable();
            $table->integer('dpthb_hib2')->nullable();
            $table->integer('polio3')->nullable();
            $table->integer('dpthb_hib3')->nullable();
            $table->integer('polio4')->nullable();
            $table->integer('campak')->nullable();
            $table->timestamps();
            $table->foreign('id_anak')
                  ->references('id')->on('anak')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imunisasi');
    }
};
