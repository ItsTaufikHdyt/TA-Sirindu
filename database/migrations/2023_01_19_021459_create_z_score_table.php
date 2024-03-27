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
        Schema::create('z_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_tbl')->default('0');
            $table->double('acuan')->default('0');
            $table->tinyInteger('jk')->default('1')->comment('jenis kelamin:1lk;2pr');
            $table->tinyInteger('var')->default('0')->comment('variasi cara pengukuran acuan');
            $table->double('m3sd')->default(null);
            $table->double('m2sd')->default(null);
            $table->double('m1sd')->default(null);
            $table->double('sd')->default(null);
            $table->double('1sd')->default(null);
            $table->double('2sd')->default(null);
            $table->double('3sd')->default(null);
            $table->foreign('jenis_tbl')
            ->references('id')->on('Jenis_tabel')
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
        Schema::dropIfExists('z_score');
    }
};
