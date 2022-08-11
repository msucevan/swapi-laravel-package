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
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('swapi_id')->unique();
            $table->string('name');
            $table->string('height');
            $table->string('mass');
            $table->string('hair_color', 25);
            $table->string('skin_color', 25);
            $table->string('eye_color', 25);
            $table->string('birth_year', 25);
            $table->string('gender', 25);
            $table->string('homeworld', 50);
            $table->integer('planet_id');
            $table->string('url', 50);
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
        Schema::dropIfExists('people');
    }
};
