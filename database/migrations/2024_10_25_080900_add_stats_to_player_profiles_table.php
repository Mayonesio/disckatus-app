<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('player_profiles', function (Blueprint $table) {
            // Estadísticas físicas adicionales
            $table->integer('jumping_height')->nullable(); // Altura de salto en cm
            $table->integer('throwing_distance')->nullable(); // Distancia de lanzamiento en metros
            $table->enum('preferred_throw', ['backhand', 'forehand', 'both'])->nullable();

            // Estadísticas de juego
            $table->integer('games_played')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('points_scored')->default(0);
            $table->integer('defensive_blocks')->default(0);

            // Medidas corporales
            $table->decimal('weight', 5, 2)->nullable(); // en kg
            $table->integer('wingspan')->nullable(); // envergadura en cm

            // Preferencias de juego
            $table->json('playing_preferences')->nullable(); // Para almacenar preferencias como JSON
            $table->text('special_skills')->nullable(); // Habilidades especiales o notas

            // Lanzamientos especiales
            $table->json('special_throws')->nullable(); // Lista de lanzamientos que domina
            $table->json('throw_ratings')->nullable();  // Niveles de dominio por lanzamiento
            $table->text('throws_notes')->nullable();   // Observaciones sobre lanzamientos

        });
    }

    public function down()
    {
        Schema::table('player_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'jumping_height',
                'throwing_distance',
                'preferred_throw',
                'games_played',
                'assists',
                'points_scored',
                'defensive_blocks',
                'weight',
                'wingspan',
                'playing_preferences',
                'special_skills'
            ]);
        });
    }
};