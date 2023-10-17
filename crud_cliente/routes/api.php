<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VendaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rota para listar todos os clientes
Route::get('/clientes', [ClienteController::class, 'index']);

// Rota para adicionar um novo cliente
Route::post('/clientes', [ClienteController::class, 'store']);

// Consultar um único cliente
Route::get('/clientes/{cliente}', 'ClienteController@show');

// Rota para atualizar um cliente existente
Route::put('/clientes/{cliente}', [ClienteController::class, 'update']);

// Excluir um cliente
Route::delete('/clientes/{cliente}', 'ClienteController@destroy');




// Rotas para ações do controlador
Route::post('/vendas', [VendaController::class, 'store']);
Route::get('/vendas/{id}', [VendaController::class, 'show']);
Route::put('/vendas/{id}', [VendaController::class, 'update']);
Route::delete('/vendas/{id}', [VendaController::class, 'destroy']);


