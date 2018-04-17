<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->dropColumn('link_type_id');
            $table->string('link_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('links', 'link_type')) {
            Schema::table('links', function (Blueprint $table) {
                $table->dropColumn('link_type');
                $table->integer('link_type_id');
            });
        }
    }
}
