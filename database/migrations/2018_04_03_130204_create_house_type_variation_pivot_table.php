<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseTypeVariationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_type_variation', function (Blueprint $table) {
            $table->integer('house_type_id')->unsigned()->index();
            $table->foreign('house_type_id')->references('id')->on('house_types')->onDelete('cascade');
            $table->integer('variation_id')->unsigned()->index();
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->primary(['house_type_id', 'variation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('house_type_variation');
    }
}
