<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroCliente extends Model
{
    use HasFactory;

    protected $table = 'cadastro_clientes'; // Certifique-se de que o nome da tabela está correto

    protected $fillable = ['name', 'email', 'email_verified_at', 'password']; // Verifique o campo email_verified_at
}
