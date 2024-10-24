<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('player_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('position')->nullable(); // handler, cutter, both
            $table->integer('jersey_number')->nullable();
            $table->integer('height')->nullable();
            $table->string('gender')->nullable();
            $table->integer('experience_years')->default(0);
            $table->integer('speed_rating')->nullable();
            $table->integer('endurance_rating')->nullable();
            $table->text('notes')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_profiles');
    }
};
