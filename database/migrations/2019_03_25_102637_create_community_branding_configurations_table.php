<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityBrandingConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dev')->create('cm_community_branding_configurations', function (Blueprint $table) {
            $table->integer('community_id');
            $table->primary('community_id');
            $table->foreign('community_id')
                ->references('COMMUNITYID')->on('osusr_mlv_community')
                ->onDelete('cascade');
            $table->string('redirect_url')->nullable();
            $table->longText('redirect_email')->nullable();
            $table->string('redirect_phone')->nullable();
            $table->string('redirect_phone_ext')->nullable();
            $table->string('community_page_rental_url')->nullable();
            $table->string('community_page_vacant_url')->nullable();
            $table->string('community_page_foreclosure_url')->nullable();
            $table->longText('landing_page_content')->nullable();
            $table->longText('program_page_content_rental')->nullable();
            $table->longText('program_page_content_vacant')->nullable();
            $table->longText('program_page_content_foreclosure')->nullable();
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
        Schema::connection('mysql_dev')->dropIfExists('cm_community_branding_configurations');
    }
}
