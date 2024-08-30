<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestineController;
use App\Http\Controllers\ProdutoController;

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
Route::get('/clientes', [DestineController::class, 'getAllCliente']);

// Rota para criar um novo cliente
Route::post('/clientes', [DestineController::class, 'createCliente']);

// Rota para obter um cliente específico pelo ID
Route::get('/clientes/{id}', [DestineController::class, 'getCliente']);

// Rota para atualizar um cliente específico pelo ID
Route::put('/clientes/{id}', [DestineController::class, 'updateCliente']);

// Rota para deletar um cliente específico pelo ID
Route::delete('/clientes/{id}', [DestineController::class, 'deleteCliente']);




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



// Exemplo de rota protegida com middleware de autenticação (opcional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
