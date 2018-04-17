<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('session_id');
            $table->integer('source_id');
            $table->integer('target_id');
            $table->string('source_entity');
            $table->string('target_entity');
            $table->integer('link_type_id');
            $table->integer('up_votes');
            $table->integer('down_votes');
            $table->decimal('score');
            $table->integer('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
