<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('development_id')->unsigned()->index();
            $table->string('house_type_name');
            $table->string('house_type_desc');
            $table->string('floor_plan');
            $table->string('house_img');
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
        Schema::drop('house_types');
    }
}
