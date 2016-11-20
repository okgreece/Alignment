<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUtilityFieldsToFilesTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function(Blueprint $table) {

            $table->boolean('parsed')->default(0)->after('public');
            $table->integer('user_id')->after('parsed');

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function(Blueprint $table) {
            $table->dropColumn('parsed');
            $table->dropColumn('user_id');
        });
    }

}