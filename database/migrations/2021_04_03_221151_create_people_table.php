<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            
             $table->increments('id');
             $table->string('name');
             $table->string('trener')->nullable();
             $table->string('club')->nullable();
             $table->string('clubid')->nullable();
             $table->string('oblid')->nullable();
             $table->string('roz')->nullable();
             $table->string('si')->nullable();
             $table->string('rik')->nullable();
             $table->text('grup')->nullable();
             $table->integer('userid')->nullable();
             $table->integer('acauntid')->nullable();
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
        Schema::dropIfExists('people');
    }
}
