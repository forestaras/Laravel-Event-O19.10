<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('userid');
             $table->integer('redactorid')->nullable();
             $table->integer('secretarid')->nullable();
             $table->integer('golsudid')->nullable();
             $table->integer('clubid')->nullable();
             $table->integer('oblid')->nullable();
            $table->string('title');
            $table->date ( 'datastart');
            $table->date ( 'datafinish');
            $table->string('org');
            $table->boolean('activ')-> default('1');
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
        Schema::dropIfExists('event');
    }
}
