<?php

namespace App\Models;




class Endereco extends RModel
{

    // Define a tabela associada ao modelo
    protected $table = 'enderecos';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'logradouro',
        'numero',
        'cidade',
        'estado',
        'cep',
        'complemento',
        'usuario_id'
    ];

    // Define a chave primária se não for 'id'
    protected $primaryKey = 'id';

    // Define se a chave primária é auto-incrementada
    public $incrementing = true;

    // Define o tipo de chave primária (integer por padrão)
    protected $keyType = 'int';

    // Indica se o modelo usa timestamps
    public $timestamps = true;

    /**
     * Define o relacionamento com o modelo Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }
}
