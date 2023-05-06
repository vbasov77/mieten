<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Details extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->integer('obj_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('price')->default(0);
            $table->integer('capacity')->default(1);
            $table->string('count_rooms');
            $table->string('service')->nullable();
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
        Schema::dropIfExists('details');
    }
}
