<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeininsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geinins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user');
            $table->string('image')->nullable();
            $table->date('birthday')->nullable();
            $table->string('activity_place')->nullable();
            $table->string('genre');
            $table->string('role');
            $table->string('creater');
            $table->string('target');
            $table->string('monomane')->nullable();
            $table->string('favorite_geinin')->nullable();
            $table->string('favorite_neta')->nullable();
            $table->string('favorite_tv_program')->nullable();
            $table->string('laughing_event')->nullable();
            $table->text('self_introduce')->nullable();
            $table->string('email');
            $table->string('password');
            $table->integer('favorite_count');
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
        Schema::dropIfExists('geinins');
    }
}
