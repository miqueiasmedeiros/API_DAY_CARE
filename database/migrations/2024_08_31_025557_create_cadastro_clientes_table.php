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
        Schema::create('cadastro_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('endereco')->nullable(); // Campo para endereço
            $table->string('cidade')->nullable();   // Campo para cidade
            $table->string('estado')->nullable();   // Campo para estado
            $table->softDeletes(); // Adiciona o campo deleted_at para soft deletes
            $table->timestamps();  // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadastro_clientes');
    }
};
