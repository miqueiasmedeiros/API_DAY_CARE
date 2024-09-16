<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProdutoController extends Controller
{
    // Método para obter todos os produtos
    public function getAllProduto()
    {
        $produtos = Produto::all();
        return response()->json($produtos, 200);
    }

    // Método para criar um novo produto
    public function createProduto(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'valor' => 'required|numeric', // Atualizado de 'preco' para 'valor'
                'foto' => 'nullable|string',
                'descricao' => 'nullable|string',
                'categoria_id' => 'required|integer|exists:categorias,id' // Certifique-se de que 'categorias' é uma tabela válida
            ]);

            $produto = Produto::create($request->all());

            return response()->json($produto, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obter um produto específico pelo ID
    public function getProduto($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $produto = Produto::findOrFail($id);

            return response()->json($produto, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para atualizar um produto específico pelo ID
    public function updateProduto(Request $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $request->validate([
                'nome' => 'string|max:255',
                'valor' => 'numeric', // Atualizado de 'preco' para 'valor'
                'foto' => 'nullable|string',
                'descricao' => 'nullable|string',
                'categoria_id' => 'integer|exists:categorias,id'
            ]);

            $produto = Produto::findOrFail($id);
            $produto->update($request->all());

            return response()->json($produto, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para deletar um produto específico pelo ID
    public function deleteProduto($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $produto = Produto::findOrFail($id);
            $produto->delete();

            return response()->json([
                'message' => 'Product successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
