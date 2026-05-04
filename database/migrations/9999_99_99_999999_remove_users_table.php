<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Elimina tablas de usuarios que no deberían estar en pieces-service
     * ya que la autenticación es manejada por auth-service.
     */
    public function up(): void
    {
        // Primero eliminar la tabla dependiente
        Schema::dropIfExists('refresh_tokens');

        // Luego eliminar users
        Schema::dropIfExists('users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opcional (puedes dejar vacío o recrear si quieres)
    }
};
