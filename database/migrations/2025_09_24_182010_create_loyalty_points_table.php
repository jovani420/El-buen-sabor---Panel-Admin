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
       // La tabla 'loyalty_points' almacena los registros de puntos de fidelidad de los usuarios.
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();

            // La clave foránea que enlaza los puntos al usuario.
            // constrained() crea automáticamente la relación con la tabla 'users'.
            // onDelete('cascade') asegura que los puntos de un usuario se borren si el usuario es eliminado.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->integer('points_earned')->default(0);
            $table->integer('points_redeemed')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_points');
    }
};
