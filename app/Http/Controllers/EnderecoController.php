<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EnderecoController extends Controller
{
    // Método para obter todos os endereços
    public function getAllEnderecos()
    {
        $enderecos = Endereco::all();
        return response()->json($enderecos, 200);
    }

    // Método para criar um novo endereço
    public function createEndereco(Request $request)
    {
        try {
            $request->validate([
                'logradouro' => 'required|string|max:255',
                'numero' => 'required|string|max:50',
                'cidade' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'cep' => 'required|string|max:20',
                'complemento' => 'nullable|string|max:255',
                'usuario_id' => 'required|integer|exists:usuarios,id'
            ]);

            $endereco = Endereco::create($request->all());

            return response()->json($endereco, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obter um endereço específico pelo ID
    public function getEndereco($id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Tenta encontrar o endereço pelo ID
            $endereco = Endereco::findOrFail($id);

            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para atualizar um endereço específico pelo ID
    public function updateEndereco(Request $request, $id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $request->validate([
                'logradouro' => 'sometimes|required|string|max:255',
                'numero' => 'sometimes|required|string|max:50',
                'cidade' => 'sometimes|required|string|max:100',
                'estado' => 'sometimes|required|string|max:100',
                'cep' => 'sometimes|required|string|max:20',
                'complemento' => 'nullable|string|max:255',
                'usuario_id' => 'sometimes|required|integer|exists:usuarios,id'
            ]);

            $endereco = Endereco::findOrFail($id);
            $endereco->update($request->all());

            return response()->json($endereco, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para deletar um endereço específico pelo ID
    public function deleteEndereco($id)
    {
        try {
            // Valida se o ID é um número
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Encontra o endereço pelo ID ou lança uma exceção se não encontrado
            $endereco = Endereco::findOrFail($id);
            $endereco->delete();

            // Retorna uma mensagem indicando que o endereço foi deletado com sucesso
            return response()->json([
                'message' => 'Address successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Retorna erro 404 se o endereço não for encontrado
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        } catch (\Exception $e) {
            // Retorna erro 500 para outros problemas
            return response()->json([
                'message' => 'An error occurred while deleting the address',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
