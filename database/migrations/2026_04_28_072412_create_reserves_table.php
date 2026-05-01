<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('id_vacation')
                  ->constrained('vacations')
                  ->onDelete('cascade');
            $table->timestamps();

            // Un usuario no puede reservar el mismo paquete dos veces
            $table->unique(['id_user', 'id_vacation']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};