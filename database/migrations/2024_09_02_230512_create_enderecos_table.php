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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments("id"); 
            $table->string("logradouro"); 
            $table->string("numero"); 
            $table->string("cidade"); 
            $table->string("estado"); 
            $table->string("cep"); 
            $table->string("complemento"); 

            $table->integer("usuario_id")
                    ->unsigned();

            $table->timestamps();
            $table->foreign("usuario_id")
                    ->references("id")->on("usuarios") 
                    ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
