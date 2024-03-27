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
        Schema::create('fuzzy', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->float('a')->nullable();
            $table->float('b')->nullable();
            $table->float('c')->nullable();
            $table->float('d')->nullable();
            $table->tinyInteger('type'); //1. naik 2. turun 3. segitiga 4.trapesium
            $table->tinyInteger('fuzzy_set');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuzzy');
    }
};
