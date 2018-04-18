<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("prefix1_id");
            $table->string("namespace1_id");
            $table->string("prefix2_id");
            $table->string("namespace2_id");
            $table->string("aggregate")->default("max");
            $table->integer("filter_limit")->default(10);
            $table->decimal("thre1")->default("0.5");
            $table->string("path1a")->default("?a/skos:prefLabel");
            $table->string("path1b")->default("?b/skos:prefLabel");
            $table->string("trans1a");
            $table->string("trans1b");
            $table->string("trans1c");
            $table->string("trans1d");
            $table->decimal("thre2")->default("0.5");
            $table->string("path2a")->default("?a/skos:prefLabel");
            $table->string("path2b")->default("?b/skos:prefLabel");
            $table->string("trans2a");
            $table->string("trans2b");
            $table->string("trans2c");
            $table->string("trans2d");
            $table->decimal("thre3")->default("0.5");
            $table->string("path3a")->default("?a/skos:prefLabel");
            $table->string("path3b")->default("?b/skos:prefLabel");
            $table->string("trans3a");
            $table->string("trans3b");
            $table->string("trans3c");
            $table->string("trans3d");
            $table->decimal("thre4")->default("0.5");
            $table->string("path4a")->default("?a/ skos:prefLabel");
            $table->string("path4b")->default("?b/skos:prefLabel");
            $table->string("trans4a");
            $table->string("trans4b");
            $table->string("trans4c");
            $table->string("trans4d");
            $table->decimal("thre5")->default("0.5");
            $table->string("path5a")->default("?a/skos:prefLabel");
            $table->string("path5b")->default("?b/skos:prefLabel");
            $table->string("trans5a");
            $table->string("trans5b");
            $table->string("trans5c");
            $table->string("trans5d");
            $table->decimal("thre6")->default("0.5");
            $table->string("path6a")->default("?a/skos:prefLabel");
            $table->string("path6b")->default("?b/skos:prefLabel");
            $table->string("trans6a");
            $table->string("trans6b");
            $table->string("trans6c");
            $table->string("trans6d");
            $table->boolean("checkMinC1")->default("0.5");
            $table->decimal("minC1");
            $table->boolean("checkMaxC1")->default("1.0");
            $table->decimal("maxC1");
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
         * Schema::drop('settings');
         */
    }
}
