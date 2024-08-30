<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    // Se o nome da tabela for diferente do pluralizado automaticamente pelo Laravel, defina-o aqui
    protected $table = 'produtos';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'preco',
        'descricao',
    ];

    public $timestamps = true; 


}
