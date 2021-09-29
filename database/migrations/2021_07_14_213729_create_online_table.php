<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eventid');
            $table->integer('userid');
            $table->string('name');
             $table->string('pass');
             $table->string('starovi')->nullable();
             $table->string('startovioff')->nullable();
             $table->string('rezult')->nullable();
             $table->string('rezultoff')->nullable();
             $table->string('startclok')->nullable();
             $table->string('split')->nullable();
             $table->string('splitanaliz')->nullable();
             $table->string('stop')->nullable();
             $table->text('datestart')->nullable();
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
        Schema::dropIfExists('online');
    }
}
