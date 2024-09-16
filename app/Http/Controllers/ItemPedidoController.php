<?php

namespace App\Http\Controllers;

use App\Models\ItemPedido;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ItemPedidoController extends Controller
{
    // Método para obter todos os itens do pedido
    public function getAllItensPedido()
    {
        $itens = ItemPedido::all();
        return response()->json($itens, 200);
    }
    public function createItemPedido(Request $request)
    {
        try {
            // Validação dos dados recebidos
            $request->validate([
                'quantidade' => 'required|integer|min:1',
                'valor' => 'required|numeric',
                'dt_item' => 'required|date',
                'produto_id' => 'required|integer|exists:produtos,id',
                'usuario_id' => 'required|integer|exists:usuarios,id',
                'pedido_id' => 'nullable|integer'
            ]);
    
            // Verifica se um pedido com o ID fornecido já existe ou cria um novo pedido
            $pedido = $request->pedido_id 
                ? Pedido::find($request->pedido_id)
                : Pedido::where('usuario_id', $request->usuario_id)
                        ->where('status', 'ABER')
                        ->first();
    
            // Se o pedido não existe, está com o status 'PAGO', ou não está ativo, cria um novo pedido
            if (!$pedido || $pedido->status === 'PAGO' || $pedido->status !== 'ABER') {
                $pedido = Pedido::create([
                    'datapedido' => now(),
                    'status' => 'ABER',
                    'usuario_id' => $request->usuario_id,
                ]);
            }
    
            // Cria o item do pedido vinculado ao pedido existente ou recém-criado
            $itemPedido = ItemPedido::create([
                'quantidade' => $request->quantidade,
                'valor' => $request->valor,
                'dt_item' => $request->dt_item,
                'produto_id' => $request->produto_id,
                'pedido_id' => $pedido->id,
            ]);
    
            // Resposta padrão para a criação do item do pedido
            return response()->json($itemPedido, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    



    // Método para obter um item específico do pedido pelo ID
    public function getItemPedido($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $itemPedido = ItemPedido::findOrFail($id);

            return response()->json($itemPedido, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cart item not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para atualizar um item específico do pedido pelo ID
    public function updateItemPedido(Request $request, $id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $request->validate([
                'quantidade' => 'integer|min:1',
                'valor' => 'numeric',
                'dt_item' => 'date',
                'produto_id' => 'integer|exists:produtos,id',
                'pedido_id' => 'integer|exists:pedidos,id',
            ]);

            $itemPedido = ItemPedido::findOrFail($id);
            $itemPedido->update($request->all());

            return response()->json($itemPedido, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cart item not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para deletar um item específico do pedido pelo ID
    public function deleteItemPedido($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            $itemPedido = ItemPedido::findOrFail($id);
            $itemPedido->delete();

            return response()->json([
                'message' => 'Cart item successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cart item not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the cart item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método para obter o pedido mais atual e seus itens do carrinho
public function getCurrentPedidoWithItems($usuarioId)
{
    try {
        // Valida o formato do ID do usuário
        if (!is_numeric($usuarioId)) {
            return response()->json([
                'message' => 'Invalid user ID format. ID must be numeric.'
            ], 400);
        }

        // Encontra o pedido mais recente com status 'ABER' para o usuário
        $pedido = Pedido::where('usuario_id', $usuarioId)
                        ->where('status', 'ABER')
                        ->latest('datapedido')
                        ->first();

        // Se não houver um pedido ativo, retorna uma resposta apropriada
        if (!$pedido) {
            return response()->json([
                'message' => 'No active order found for the user.'
            ], 404);
        }

        // Obtém todos os itens associados ao pedido
        $itens = ItemPedido::where('pedido_id', $pedido->id)->get();

        // Retorna o pedido e seus itens
        return response()->json([
            'pedido' => $pedido,
            'itens' => $itens
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while retrieving the current order with items.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}



