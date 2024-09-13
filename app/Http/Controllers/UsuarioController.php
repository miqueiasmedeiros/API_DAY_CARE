<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class UsuarioController extends Controller
{
    // Retorna todos os usuários
    public function getAllUsuarios()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios, 200);
    }

    // Cria um novo usuário
    public function createUsuario(Request $request)
    {
        try {
            // Validação dos campos
            $request->validate([
                'login' => 'required|string|max:100|unique:usuarios,login',
                'password' => 'required|string|min:6',
                'nome' => 'required|string|max:50',
            ]);

            // Cria o novo usuário
            $usuario = Usuarios::create([
                'login' => $request->login,
                'password' => bcrypt($request->password), // Criptografa a senha
                'nome' => $request->nome,
            ]);

            return response()->json($usuario, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Retorna um único usuário pelo ID
    public function getUsuario($id)
    {
        try {
            // Valida se o ID é numérico
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Encontra o usuário pelo ID
            $usuario = Usuarios::findOrFail($id);

            return response()->json($usuario, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Usuario not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Atualiza os dados de um usuário
    public function updateUsuario(Request $request, $id)
    {
        try {
            // Valida se o ID é numérico
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }
    
            // Validação dos campos
            $request->validate([
                'login' => 'string|max:100|unique:usuarios,login,' . $id,
                'password' => 'sometimes|string|min:6', // Se o campo estiver presente, deve ser uma string e no mínimo 6 caracteres
                'nome' => 'string|max:50',
            ]);
    
            // Encontra o usuário pelo ID e atualiza
            $usuario = Usuarios::findOrFail($id);
            $usuario->update([
                'login' => $request->login ?? $usuario->login,
                'password' => !empty($request->password) ? bcrypt($request->password) : $usuario->password, // Atualiza a senha se fornecida e não vazia
                'nome' => $request->nome ?? $usuario->nome,
            ]);
    
            return response()->json($usuario, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Usuario not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Deleta um usuário
    public function deleteUsuario($id)
    {
        try {
            // Valida se o ID é numérico
            if (!is_numeric($id)) {
                return response()->json([
                    'message' => 'Invalid ID format. ID must be numeric.'
                ], 400);
            }

            // Encontra o usuário pelo ID e deleta
            $usuario = Usuarios::findOrFail($id);
            $usuario->delete();

            return response()->json([
                'message' => 'Usuario successfully deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Usuario not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Gera um token para o usuário
    public function generateToken(Request $request)
    {
        try {
            $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = Usuarios::where('login', $request->login)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while generating the token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Revoga o token do usuário
    public function revokeToken(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
            ]);

            $token = PersonalAccessToken::findToken($request->token);

            if ($token) {
                $token->delete();
                return response()->json([
                    'message' => 'Token revoked successfully'
                ], 200);
            }

            return response()->json([
                'message' => 'Token not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while revoking the token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
