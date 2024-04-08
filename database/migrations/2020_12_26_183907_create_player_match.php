<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerMatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_match', function (Blueprint $table) {
            $table->foreignId('player_id')->constrained('players');
            $table->foreignId('match_id')->constrained('matches');
            $table->primary(['player_id', 'match_id']);
            $table->enum('team_type', ['team1', 'team2']);
            $table->integer('goals');
            $table->integer('perf_o');
            $table->integer('perf_d');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_match');
    }
}
