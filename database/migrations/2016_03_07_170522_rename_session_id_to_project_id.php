<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSessionIdToProjectId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->renameColumn('session_id', 'project_id');
            $table->dropColumn('link_type_id');
            $table->string('link_type');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->renameColumn('project_id', 'session_id');
            $table->dropColumn('link_type');            
            $table->integer('link_type_id');
            
        });
    }
}
