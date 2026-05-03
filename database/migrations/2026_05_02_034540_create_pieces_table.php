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
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();

            $table->foreignId('block_id')->constrained()->cascadeOnDelete();
            
            $table->decimal('peso_teorico',10,2);
            $table->decimal('peso_real',10,2)->nullable();
            
            $table->decimal('diferencia_peso',10,2)->nullable();
            
            $table->enum('estado',['Pendiente','Fabricada'])->default('Pendiente');
            $table->timestamp('fecha_fabricacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
