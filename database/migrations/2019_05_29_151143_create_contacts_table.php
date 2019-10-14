<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contactmgmt_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->foreign('organization_id')
                ->references('ID')
                ->on('osusr_rjr_organization');
            $table->integer('community_id')->nullable();
            $table->foreign('community_id')
                ->references('COMMUNITYID')
                ->on('osusr_mlv_community')
                ->onDelete('set null');
            $table->integer('login_id')->nullable();
            $table->string('sharpspring_id')->nullable();
            $table->integer('govtype')->nullable();
            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('primary_phone_ext')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('secondary_phone_ext')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('facebook')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_contacts');
    }
}
