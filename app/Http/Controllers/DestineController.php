<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadastroCliente; // Certifique-se de que o modelo esteja corretamente referenciado

class DestineController extends Controller
{
    public function getAllCliente() {
        $cadastro_clientes = CadastroCliente::all();
        return response()->json($cadastro_clientes, 200);
    }
  
    public function createCliente(Request $request) {        
        $cadastro_clientes = new CadastroCliente;
        $cadastro_clientes->name = $request->name;
        $cadastro_clientes->email = $request->email;
        $cadastro_clientes->email_verified_at = $request->email_verified_at; // Verifique se o campo é este mesmo
        $cadastro_clientes->password = bcrypt($request->password); // Recomendado usar bcrypt para senha        
        $cadastro_clientes->endereco = $request->endereco;
        $cadastro_clientes->cidade = $request->cidade;
        $cadastro_clientes->estado = $request->estado;    
        $cadastro_clientes->save();
    
        return response()->json([
            "message" => "Cliente created"
        ], 201);
    }
  
    public function getCliente($id) {
        if (CadastroCliente::where('id', $id)->exists()) {
            $cadastro_clientes = CadastroCliente::find($id);
            return response()->json($cadastro_clientes, 200);
        } else {
            return response()->json([
                "message" => "Cliente not found"
            ], 404);
        }
    }
  
    public function updateCliente(Request $request, $id) {
        if (CadastroCliente::where('id', $id)->exists()) {
            $cadastro_clientes = CadastroCliente::find($id);
            $cadastro_clientes->name = $request->name ?? $cadastro_clientes->name;
            $cadastro_clientes->email = $request->email ?? $cadastro_clientes->email;
            $cadastro_clientes->email_verified_at = $request->email_verified_at ?? $cadastro_clientes->email_verified_at;
            $cadastro_clientes->password = $request->password ? bcrypt($request->password) : $cadastro_clientes->password;
            $cadastro_clientes->save();
  
            return response()->json([
                "message" => "Records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Cliente not found"
            ], 404);
        }
    }
  
    public function deleteCliente($id) {
        if (CadastroCliente::where('id', $id)->exists()) {
            $cadastro_clientes = CadastroCliente::find($id);
            $cadastro_clientes->delete();
  
            return response()->json([
                "message" => "Records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Cliente not found"
            ], 404);
        }
    }
}
