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
            $table->string('name'); // Nome do cliente
            $table->string('email')->unique(); // Email deve ser único
            $table->timestamp('email_verified_at')->nullable(); // Data/hora de verificação do email
            $table->string('password'); // Senha (geralmente um hash)
            $table->rememberToken(); // Token para lembrar sessão de login
            $table->timestamps(); // Cria os campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadastro_clientes'); // Exclui a tabela caso a migração seja revertida
    }
};
