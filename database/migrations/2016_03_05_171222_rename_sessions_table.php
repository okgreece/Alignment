<?php

use Illuminate\Database\Migrations\Migration;

class RenameSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sessions', 'projects');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('projects', 'sessions');
    }
}
