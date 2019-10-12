<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmContactRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_contact_role', function (Blueprint $table) {
            $table->integer('contact_id')->unsigned();
            /*$table->foreign('contact_id')
                ->references('id')
                ->on('cm_contacts')
                ->onDelete('cascade');*/
            $table->integer('role_id')->unsigned();
            /*$table->foreign('role_id')
                ->references('id')
                ->on('cm_peoples_roles')
                ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dev')->dropIfExists('cm_contact_role');
    }
}
