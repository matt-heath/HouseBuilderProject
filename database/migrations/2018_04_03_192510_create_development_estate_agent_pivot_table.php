<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevelopmentEstateAgentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('development_estate_agent', function (Blueprint $table) {
            $table->integer('development_id')->unsigned()->index();
            $table->foreign('development_id')->references('id')->on('developments')->onDelete('cascade');
            $table->integer('estate_agent_id')->unsigned()->index();
            $table->foreign('estate_agent_id')->references('id')->on('estate_agents')->onDelete('cascade');
            $table->primary(['development_id', 'estate_agent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('development_estate_agent');
    }
}
