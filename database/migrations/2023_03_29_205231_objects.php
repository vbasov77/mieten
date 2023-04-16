<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Objects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('price')->default(0);
            $table->integer('capacity')->default(1);
            $table->string('count_rooms');
            $table->string('service')->nullable();
            $table->string('title')->nullable();
            $table->text('text_obj')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}
