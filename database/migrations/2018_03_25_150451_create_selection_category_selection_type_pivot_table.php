<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionCategorySelectionTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selection_category_selection_type', function (Blueprint $table) {
            $table->integer('selection_category_id')->unsigned()->index();
            $table->foreign('selection_category_id')->references('id')->on('selection_categories')->onDelete('cascade');
            $table->integer('selection_type_id')->unsigned()->index();
            $table->foreign('selection_type_id')->references('id')->on('selection_types')->onDelete('cascade');
            $table->primary(['selection_category_id', 'selection_type_id'], 'selection_category_selection_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('selection_category_selection_type');
    }
}
