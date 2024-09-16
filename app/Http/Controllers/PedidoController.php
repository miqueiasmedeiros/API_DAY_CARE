<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    // Método para obter todos os pedidos
    public function getAllPedidos()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos, 200);
    }

    // Método para criar um novo pedido
    public function createPedido(Request $request)
    {
        try {
            $request->validate([
                'datapedido' => 'required|date',
                'status' => 'required|string|max:4',
                'usuario_id' => 'required|integer|exists:usuarios,id',
            ]);

            $pedido = Pedido::create($request->all());

            return response()->json($pedido, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obter um pedido específico pelo ID
    public function getPedido($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $pedido = Pedido::findOrFail($id);

            return response()->json($pedido, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para atualizar um pedido específico pelo ID
    public function updatePedido(Request $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $request->validate([
                'datapedido' => 'date',
                'status' => 'string|max:4',
                'usuario_id' => 'integer|exists:usuarios,id',
            ]);

            $pedido = Pedido::findOrFail($id);
            $pedido->update($request->all());

            return response()->json($pedido, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para deletar um pedido específico pelo ID
    public function deletePedido($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $pedido = Pedido::findOrFail($id);
            $pedido->delete();

            return response()->json([
                'message' => 'Order successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
