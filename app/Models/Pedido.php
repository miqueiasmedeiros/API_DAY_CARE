<?php

namespace App\Models;


class Pedido extends RModel
{

    protected $table = 'pedidos';

    protected $fillable = [
        'datapedido',
        'status',
        'usuario_id',
    ];

    // Relacionamento com o modelo Usuario (um pedido pertence a um usuário)
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}
