<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRdfnamespacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdfnamespaces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix');
            $table->string('uri');
            $table->boolean('added');
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
        Schema::drop('rdfnamespaces');
    }
}
