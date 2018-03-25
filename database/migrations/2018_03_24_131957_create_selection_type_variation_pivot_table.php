<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionTypeVariationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selection_type_variation', function (Blueprint $table) {
            $table->integer('selection_type_id')->unsigned()->index();
            $table->foreign('selection_type_id')->references('id')->on('selection_types')->onDelete('cascade');
            $table->integer('variation_id')->unsigned()->index();
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->primary(['selection_type_id', 'variation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('selection_type_variation');
    }
}
