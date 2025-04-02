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
        Schema::create('coords', function (Blueprint $table) {
            $table->id();
            $table->double('accuracy');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('speed');
            $table->boolean('start_end')->nullable();
            $table->bigInteger('timestamp');
            $table->foreignId('id_circuit')
                ->nullable()->constrained(table: 'circuits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coords');
    }
};
