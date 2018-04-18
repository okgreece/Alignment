<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnsToLinkTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_types', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->nullable();
            $table->text('group')->after('user_id')->nullable();
            $table->text('inner')->after('group')->nullable();
            $table->text('value')->after('inner')->nullable();
            $table->boolean('public')->after('value')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('link_types', function (Blueprint $table) {
            $table->dropColumn('user_id', 'group', 'inner', 'value', 'public');
        });
    }
}
