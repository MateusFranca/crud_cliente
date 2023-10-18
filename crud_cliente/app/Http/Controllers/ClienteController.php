<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    // Lista todos os clientes
    public function index() {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    // Consulta um único cliente
    public function show(Cliente $cliente) {
        return response()->json($cliente);
    }

    // Adiciona um novo cliente
    public function store(Request $request) {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'sexo' => 'required',
            'foto' => 'image',
        ]);

        $fotoURL = $request->file('foto')->store('public/fotos');

        $fotoURL = str_replace('public/', 'storage/', $fotoURL);

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'sexo' => $request->sexo,
            'foto' => $fotoURL,
        ]);

        return response()->json($cliente, 201);
    }

    // Atualiza um cliente existente
    public function update(Request $request, Cliente $cliente) {
        $rules = [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'sexo' => 'required',
        ];
    
        if ($request->hasFile('foto')) {
            $rules['foto'] = 'image';
            $fotoURL = $request->file('foto')->store('public/fotos');
            $fotoURL = str_replace('public/', 'storage/', $fotoURL);
            $cliente->update(['foto' => $fotoURL]);
        }
    
        $request->validate($rules);
    
        $cliente->update($request->except('foto'));
    
        return response()->json($cliente);
    }

    // Deleta um cliente existente
    public function destroy(Cliente $cliente) {
        $cliente->delete();

        return response()->json(['message' => 'Cliente deletado com sucesso']);
    }
}
