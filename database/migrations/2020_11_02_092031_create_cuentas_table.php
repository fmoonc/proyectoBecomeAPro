<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('summoner_name');
            $table->string('region');
            $table->string('summoner_id');
            $table->string('account_id');
            $table->string('puuid');
            $table->integer('level');
            $table->string('id_flex');
            $table->string('tier_flex');
            $table->string('img_flex');
            $table->string('rank_flex');
            $table->integer('league_points_flex');
            $table->integer('wins_flex');
            $table->integer('losses_flex');
            $table->string('id_duo');
            $table->string('tier_duo');
            $table->string('img_duo');
            $table->string('rank_duo');
            $table->integer('league_points_duo');
            $table->integer('wins_duo');
            $table->integer('losses_duo');
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
        Schema::dropIfExists('cuentas');
    }
}