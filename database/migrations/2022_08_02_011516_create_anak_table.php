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
        Schema::create('anak', function (Blueprint $table) {
            $table->uuid('id',32)->primary();
            $table->string('nama',100);
            $table->string('nama_ibu',100);
            $table->string('nama_ayah',100);
            $table->tinyInteger('jk');
            $table->string('tempat_lahir',100);
            $table->text('alamat');
            $table->date('tgl_lahir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balita');
    }
};
