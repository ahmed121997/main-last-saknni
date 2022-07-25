<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovsAndCitiesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('governorates', function (Blueprint $table) {
            $table->id();
            $table->string('governorate_name_ar',100);
            $table->string('governorate_name_en',100);
            $table->timestamps();
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_name_ar',100);
            $table->string('city_name_en',100);
            $table->integer('gov_id')->unsigned();
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
        Schema::dropIfExists('governorates');
        Schema::dropIfExists('cities');
    }
}
