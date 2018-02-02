<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateConsultantPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_consultant', function (Blueprint $table) {
            $table->integer('certificate_id')->unsigned()->index();
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->integer('consultant_id')->unsigned()->index();
            $table->foreign('consultant_id')->references('id')->on('consultants')->onDelete('cascade');
            $table->primary(['certificate_id', 'consultant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('certificate_consultant');
    }
}
