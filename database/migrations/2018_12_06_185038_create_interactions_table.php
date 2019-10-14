<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_interactions', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('contact_id');
            $table->foreign('contact_id')->references('ID')->on('osusr_rjr_contact');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('cm_interaction_types');
            $table->string('subject');
            $table->longText('body');
            $table->dateTime('date');
            $table->string('phoneNumber')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('private')->default(false);
            $table->softDeletes();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_interactions');
    }
}
