<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistersetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registerseting', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('eventid');
             $table->string('title');
             $table->string('trener');
             $table->string('club');
             $table->string('obl')->nullable();
             $table->string('roz')->nullable();
             $table->string('si')->nullable();
             $table->string('rik')->nullable();
             $table->text('grup')->nullable();
             $table->text('dni')->nullable();
             $table->text('datestop')->nullable();
             $table->integer('userid')->nullable();
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
        Schema::dropIfExists('registerseting');
    }
}
