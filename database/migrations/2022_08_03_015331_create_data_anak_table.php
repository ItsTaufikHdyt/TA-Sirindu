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
        Schema::create('data_anak', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_anak',32);
            $table->tinyInteger('bln');
            $table->string('posisi');
            $table->float('tb');
            $table->float('bb');
            $table->uuid('id_user',32);
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
        Schema::dropIfExists('data_anak');
    }
};
