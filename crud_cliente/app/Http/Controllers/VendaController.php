<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;

class VendaController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'data_da_venda' => 'required',
            'valor_da_venda' => 'required'
        ]);

        $venda = new Venda([
            'cliente_id' => $request->cliente_id,
            'data_da_venda' => $request->data_da_venda,
            'valor_da_venda' => $request->valor_da_venda,
        ]);

        $venda->save();

        return response()->json($venda, 201);
    }


    public function index()
    {
        $vendas = Venda::with('cliente')->get();

        return response()->json($vendas, 200);
    }
}
