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
        Schema::table('pieces', function (Blueprint $table) {
            // Índice clave para que el GROUP BY por estado sea ultra rápido
            $table->index('estado');
            
            // Índice compuesto recomendado para acelerar los JOINs y conteos
            $table->index(['block_id', 'estado']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pieces', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['block_id', 'estado']);
        });
    }
};
