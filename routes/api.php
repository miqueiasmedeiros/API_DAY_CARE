<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\DestineController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ItemPedidoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rota para obter todos os clientes
//Route::get('/clientes', [DestineController::class, 'getAllCliente']);

// Rota para criar um novo cliente
//Route::post('/clientes', [DestineController::class, 'createCliente']);

// Rota para obter um cliente específico pelo ID
//Route::get('/clientes/{id}', [DestineController::class, 'getCliente']);

// Rota para atualizar um cliente específico pelo ID
//Route::put('/clientes/{id}', [DestineController::class, 'updateCliente']);

// Rota para deletar um cliente específico pelo ID
//Route::delete('/clientes/{id}', [DestineController::class, 'deleteCliente']);

// Rota para gerar o token
Route::post('/login', [UsuarioController::class, 'generateToken']); 

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'getAllUsuarios']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'getUsuario']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'updateUsuario']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'deleteUsuario']);
});

// Rotas públicas
Route::post('/usuarios', [UsuarioController::class, 'createUsuario']);


// Rotas de endereços
Route::get('/enderecos', [EnderecoController::class, 'getAllEnderecos']);          // Retorna todos os endereços

Route::post('/enderecos', [EnderecoController::class, 'createEndereco']);           // Cria um novo endereço

Route::get('/enderecos/{id}', [EnderecoController::class, 'getEndereco']);          // Retorna um endereço específico pelo ID

Route::put('/enderecos/{id}', [EnderecoController::class, 'updateEndereco']);       // Atualiza os dados de um endereço específico

Route::delete('/enderecos/{id}', [EnderecoController::class, 'deleteEndereco']);    // Deleta um endereço pelo ID



// rotas de produtos

// Rota para obter todos os produtos
Route::get('/produtos', [ProdutoController::class, 'getAllProduto']);

// Rota para criar um novo produto
Route::post('/produtos', [ProdutoController::class, 'createProduto']);

// Rota para obter um produto específico pelo ID
Route::get('/produtos/{id}', [ProdutoController::class, 'getProduto']);

// Rota para atualizar um produto específico pelo ID
Route::put('/produtos/{id}', [ProdutoController::class, 'updateProduto']);

// Rota para deletar um produto específico pelo ID
Route::delete('/produtos/{id}', [ProdutoController::class, 'deleteProduto']);



// Rota para obter todas as categorias
Route::get('/categorias', [CategoriaController::class, 'getAllCategorias']);

// Rota para criar uma nova categoria
Route::post('/categorias', [CategoriaController::class, 'createCategoria']);

// Rota para obter uma categoria específica pelo ID
Route::get('/categorias/{id}', [CategoriaController::class, 'getCategoria']);

// Rota para atualizar uma categoria específica pelo ID
Route::put('/categorias/{id}', [CategoriaController::class, 'updateCategoria']);

// Rota para deletar uma categoria específica pelo ID
Route::delete('/categorias/{id}', [CategoriaController::class, 'deleteCategoria']);





Route::get('/pedidos', [PedidoController::class, 'getAllPedidos']);

Route::post('/pedidos', [PedidoController::class, 'createPedido']);

Route::get('/pedidos/{id}', [PedidoController::class, 'getPedido']);

Route::put('/pedidos/{id}', [PedidoController::class, 'updatePedido']);

Route::delete('/pedidos/{id}', [PedidoController::class, 'deletePedido']);





Route::get('/itens-pedidos', [ItemPedidoController::class, 'getAllItensPedido']);
Route::post('/itens-pedidos', [ItemPedidoController::class, 'createItemPedido']);
Route::get('/itens-pedidos/{id}', [ItemPedidoController::class, 'getItemPedido']);
Route::put('/itens-pedidos/{id}', [ItemPedidoController::class, 'updateItemPedido']);
Route::delete('/itens-pedidos/{id}', [ItemPedidoController::class, 'deleteItemPedido']);
Route::get('/pedido/atual/{usuarioId}', [ItemPedidoController::class, 'getCurrentPedidoWithItems']);



// Exemplo de rota protegida com middleware de autenticação (opcional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
