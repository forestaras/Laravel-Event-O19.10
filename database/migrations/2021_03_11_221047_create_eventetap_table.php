<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventetapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventetap', function (Blueprint $table) {
             $table->increments('id');
             $table->string('title');
             $table->integer('eventid');
             $table->integer('contactid')->nullable();
             $table->integer('userid')->nullable();
             $table->string('local')->nullable();
             $table->string( 'datastart')->nullable();
             $table->integer('registersetid')->nullable();
             $table->string('org')->nullable();
             $table->string('bul')->nullable();
             $table->string('inf')->nullable();
             $table->string('rez')->nullable();
             $table->integer('onlineid')->nullable();
             $table->text('text')->nullable();
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
        Schema::dropIfExists('eventetap');
    }
}
