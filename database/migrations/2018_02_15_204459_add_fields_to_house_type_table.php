<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToHouseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('house_types', function ($table) {
            $table->integer('house_type_price')->unsigned()->index();
            $table->string('bedrooms');
            $table->string('bathrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('house_types', function($table) {
            $table->dropColumn('house_type_price');
            $table->dropColumn('bedrooms');
            $table->dropColumn('bathrooms');
        });
    }
}
