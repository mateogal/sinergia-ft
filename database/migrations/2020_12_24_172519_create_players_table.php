<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users');
            $table->primary('id');
            $table->string('name', 30);
            $table->string('lastname', 50);
            $table->string('alias', 20);
            $table->string('photo', 255);
            $table->integer('offense');
            $table->integer('defense');
            $table->enum('type', ['offensive', 'defensive', 'goalkeeper']);
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
        Schema::dropIfExists('players');
    }
}
