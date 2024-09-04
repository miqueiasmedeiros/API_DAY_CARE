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
        Schema::create('itens_pedidos', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("quantidade"); 
            $table->decimal("valor"); 
            $table->datetime("dt_item"); 

            $table->integer("produto_id")->unsigned(); 
            $table->integer("pedido_id")->unsigned(); 

            $table->timestamps();

            $table->foreign("produto_id")
                    ->references("id")
                    ->on("produtos")->onDelete("cascade"); 

            $table->foreign("pedido_id")
                    ->references("id")
                    ->on("pedidos")->onDelete("cascade"); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_pedidos');
    }
};
