<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesstokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('accesstokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');
            $table->string('code');
            $table->string('token_type');
            $table->integer('expires_in');
            $table->text('access_token');
            $table->text('data');
            $table->text('refresh_token');
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
        Schema::dropIfExists('accesstokens');
    }
}
