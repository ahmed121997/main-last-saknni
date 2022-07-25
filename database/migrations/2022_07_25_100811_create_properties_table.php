<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('type_property_id')->unsigned();
            $table->integer('list_view_id')->unsigned();
            $table->integer('type_finish_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('type_payment_id')->unsigned();
            $table->enum('type_rent' , array('daily', 'monthly'));
            $table->enum('list_section' , array('sell', 'rent'));
            $table->string('area',20);
            $table->smallInteger('num_floor');
            $table->smallInteger('num_rooms');
            $table->smallInteger('num_bathroom');
            $table->string('loaction');
            $table->integer('price');
            $table->string('trans_payment_id');
            $table->tinyInteger('special');
            $table->string('link_youtube');
            $table->timestamps();
        });


        Schema::create('description_properties', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->text('details');
            $table->integer('property_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('images', function(Blueprint $table){
            $table->id();
            $table->string('source');
            $table->integer('property_id')->unsigned();
            $table->timestamps();
        });



        Schema::create('list_views', function(Blueprint $table){
            $table->id();
            $table->string('list_en', 100);
            $table->string('list_ar', 100);
        });

        Schema::create('type_finishes', function(Blueprint $table){
            $table->id();
            $table->string('type_en', 100);
            $table->string('type_ar', 100);
        });


        Schema::create('type_payments', function(Blueprint $table){
            $table->id();
            $table->string('type_en', 100);
            $table->string('type_ar', 100);
        });


        Schema::create('type_property', function(Blueprint $table){
            $table->id();
            $table->string('type_en', 100);
            $table->string('type_ar', 100);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
        Schema::dropIfExists('description_properties');
        Schema::dropIfExists('images');
        Schema::dropIfExists('list_views');
        Schema::dropIfExists('type_finishes');
        Schema::dropIfExists('type_payments');
        Schema::dropIfExists('type_property');
    }
}
