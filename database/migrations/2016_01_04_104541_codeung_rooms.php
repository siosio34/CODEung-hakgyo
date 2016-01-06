<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CodeungRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function(Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('name');
            $table->integer('master_id')->unsigned();
            $table->foreign('master_id')->references('id')->on('users');
            $table->string('password', 60);
            $table->string('type');
            $table->string('tag');
            $table->text('description');
            $table->longText('code');
            $table->integer('user_limit');
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
        Schema::drop('rooms');
    }
}
