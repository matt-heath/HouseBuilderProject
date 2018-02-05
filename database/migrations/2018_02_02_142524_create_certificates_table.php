<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('certificate_name');
            $table->boolean('certificate_check')->default(false);
            $table->string('certificate_doc')->nullable();
            $table->integer('certificate_category_id')->unsigned()->index();
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
        //
        Schema::drop('certificates');
    }
}
