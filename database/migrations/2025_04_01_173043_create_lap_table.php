<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laps', function (Blueprint $table) {
            $table->id();

            $table->boolean("isValid");
            $table->time("time");
            $table->float("distance_traveled")->nullable();
            $table->float("avg_speed");
            $table->float("top_speed");
            $table->float("avg_accuracy");
            $table->integer("coords_count");

            $table->foreignId('id_user')->constrained(table: 'users')->onDelete('CASCADE');
            $table->foreignId('id_circuit')->constrained(table: 'circuits')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lap');
    }
};
