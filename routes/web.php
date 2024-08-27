<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\InscricoesController;
use App\Http\Controllers\PedidosController;

Route::get('/', function () {
    return view('home');
});



/* CURSOS */
Route::get('/cursos', function () {
    return view('curso');
});

Route::get('/api/cursos', [CursoController::class, 'index']);
Route::get('/api/cursos/{id}', [CursoController::class, 'get']);
Route::post('/api/cursos/inserir', [CursoController::class, 'inserir']);
Route::post('/api/cursos/alterar/{id}', [CursoController::class, 'alterar']);
Route::get('/api/cursos/deletar/{id}', [CursoController::class, 'deletar']);

/* ALUNOS */
Route::get('/alunos', function () {
    return view('aluno');
});

Route::get('/api/alunos', [AlunosController::class, 'index']);
Route::get('/api/alunos/{id}', [AlunosController::class, 'get']);
Route::post('/api/alunos/inserir', [AlunosController::class, 'inserir']);
Route::post('/api/alunos/alterar/{id}', [AlunosController::class, 'alterar']);
Route::get('/api/alunos/deletar/{id}', [AlunosController::class, 'deletar']);


/* INSCIRCOES */
Route::get('/inscricoes', function () {
    return view('inscricoes');
});

Route::get('/api/inscricoes', [InscricoesController::class, 'index']);
Route::get('/api/inscricoes/{id}', [InscricoesController::class, 'get']);
Route::post('/api/inscricoes/inserir', [InscricoesController::class, 'inserir']);
Route::post('/api/inscricoes/alterar/{id}', [InscricoesController::class, 'alterar']);
Route::get('/api/inscricoes/deletar/{id}', [InscricoesController::class, 'deletar']);


/* PEDIDOS */
Route::get('/pedidos', function () {
    return view('pedidos');
});

Route::get('/api/pedidos', [PedidosController::class, 'index']);
Route::get('/api/pedidos/{id}', [PedidosController::class, 'get']);
Route::post('/api/pedidos/inserir', [PedidosController::class, 'inserir']);
Route::post('/api/pedidos/alterar/{id}', [PedidosController::class, 'alterar']);
Route::get('/api/pedidos/deletar/{id}', [PedidosController::class, 'deletar']);
Route::post('/criar-pagamento', [PedidosController::class, 'criarPagamento']);
