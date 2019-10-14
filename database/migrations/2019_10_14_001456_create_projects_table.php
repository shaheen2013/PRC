<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id');
            $table->integer('osusr_mlv_community_id');
            $table->foreign('osusr_mlv_community_id')
              ->references('COMMUNITYID')
              ->on('osusr_mlv_community')
              ->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
