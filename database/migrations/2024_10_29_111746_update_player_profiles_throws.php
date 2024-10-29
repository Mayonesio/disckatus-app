<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('player_profiles', function (Blueprint $table) {
            // Eliminar columnas anteriores
            $table->dropColumn([
                'hammer_rating',
                'scoober_rating',
                'push_pass_rating',
                'thumber_rating',
                'low_release_rating',
                'high_release_rating',
                'espantaguiris_rating',
                'blade_rating',
                'no_look_rating',
                'over_the_head_rating',
                'upside_down_rating'
            ]);

            // Añadir nueva columna para almacenar los lanzamientos y sus niveles
            $table->json('throw_levels')->nullable();
            $table->text('throws_notes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('player_profiles', function (Blueprint $table) {
            $table->dropColumn(['throw_levels']);
            
            // Restaurar columnas anteriores
            $table->integer('hammer_rating')->nullable();
            $table->integer('scoober_rating')->nullable();
            $table->integer('push_pass_rating')->nullable();
            $table->integer('thumber_rating')->nullable();
            $table->integer('low_release_rating')->nullable();
            $table->integer('high_release_rating')->nullable();
            $table->integer('espantaguiris_rating')->nullable();
            $table->integer('blade_rating')->nullable();
            $table->integer('no_look_rating')->nullable();
            $table->integer('over_the_head_rating')->nullable();
            $table->integer('upside_down_rating')->nullable();
        });
    }
};