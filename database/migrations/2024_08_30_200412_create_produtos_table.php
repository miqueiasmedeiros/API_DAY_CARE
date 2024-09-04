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
    Schema::create('produtos', function (Blueprint $table) {
        $table->increments("id");
        $table->string("nome", 100);
        $table->decimal("valor", 10, 2);
        $table->string('foto')->nullable();
        $table->text("descricao")->nullable();  // Removido o argumento de tamanho
        $table->unsignedInteger("categoria_id");  // Forma alternativa para garantir que é unsigned
        $table->timestamps();
        
        // Definindo a chave estrangeira
        $table->foreign("categoria_id")
              ->references("id")->on("categorias")
              ->onDelete("cascade");
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
