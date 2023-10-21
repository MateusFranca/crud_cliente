<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::all();

        return response()->json($vendas, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'valor' => 'required',
            'nome' => 'required',
            'descricao' => 'required',
            'cliente_id' => 'required',
        ]);

        $venda = Venda::create($request->all());

        return response()->json($venda, 201);
    }
    
    public function show($id)
    {
        $venda = Venda::with('cliente')->find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        return response()->json($venda, 200);
    }

    public function update(Request $request, $id)
    {
        $venda = Venda::find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $request->validate([
            'cliente_id' => 'required',
            'data_da_venda' => 'required',
            'valor_da_venda' => 'required'
        ]);

        $venda->cliente_id = $request->cliente_id;
        $venda->data_da_venda = $request->data_da_venda;
        $venda->valor_da_venda = $request->valor_da_venda;

        $venda->save();

        return response()->json($venda, 200);
    }

    public function destroy($id)
    {
        $venda = Venda::find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $venda->delete();

        return response()->json(['message' => 'Venda excluída com sucesso'], 200);
    }
}
