<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateRejectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('certificate_rejections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certificate_id')->unsigned()->index();
            $table->text('rejection_reason');
            $table->text('rejection_response')->nullable();
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
        Schema::drop('certificate_rejections');
    }
}
