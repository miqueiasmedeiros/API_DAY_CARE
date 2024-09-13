<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios'; // Nome da tabela

    protected $fillable = [
        'login', 
        'password',
        'nome',
    ];

    // Para usar soft deletes (caso queira adicionar essa funcionalidade)
    protected $dates = ['deleted_at'];
}
