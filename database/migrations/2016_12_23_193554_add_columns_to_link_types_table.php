<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer("user_id")->after("id");
            $table->text("group")->after("user_id");
            $table->text("inner")->after("group");
            $table->text("value")->after("inner");            
            $table->boolean("public")->after("value");
            
            
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
            $table->dropColumn("user_id");
            $table->dropColumn("group");
            $table->dropColumn("inner");
            $table->dropColumn("value");
            $table->dropColumn("public");
        });
    }
}
