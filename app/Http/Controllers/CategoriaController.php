<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    // Método para obter todas as categorias
    public function getAllCategorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias, 200);
    }

    // Método para criar uma nova categoria
    public function createCategoria(Request $request)
    {
        try {
            $request->validate([
                'categoria' => 'required|string|max:255',
            ]);

            $categoria = Categoria::create($request->all());

            return response()->json($categoria, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obter uma categoria específica pelo ID
    public function getCategoria($id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Tenta encontrar a categoria pelo ID
            $categoria = Categoria::findOrFail($id);

            return response()->json($categoria, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para atualizar uma categoria específica pelo ID
    public function updateCategoria(Request $request, $id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $request->validate([
                'categoria' => 'string|max:255',
            ]);

            $categoria = Categoria::findOrFail($id);
            $categoria->update($request->all());

            return response()->json($categoria, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para deletar uma categoria específica pelo ID
    public function deleteCategoria($id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Encontra a categoria pelo ID ou lança uma exceção se não encontrada
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            // Retorna uma mensagem indicando que a categoria foi deletada com sucesso
            return response()->json([
                'message' => 'Category successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Retorna erro 404 se a categoria não for encontrada
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            // Retorna erro 500 para outros problemas
            return response()->json([
                'message' => 'An error occurred while deleting the category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
