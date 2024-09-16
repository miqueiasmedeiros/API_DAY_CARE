<?php

namespace App\Models;


class ItemPedido extends RModel
{

    protected $table = 'itens_pedidos';

    protected $fillable = [
        'quantidade',
        'valor',
        'dt_item',
        'produto_id',
        'pedido_id',
    ];

    // Relacionamento com o Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relacionamento com o Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
