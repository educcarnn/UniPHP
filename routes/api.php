<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Rotas para operações relacionadas a posts


// Rota para criar um novo post
// Rota para listar todos os posts
Route::get('/get', [PostController::class, 'index']);

// Rota para exibir um post específico
//Route::get('/{id}', [PostController::class, 'show']);

// Rota para atualizar um post existente
Route::patch('/{id}', [PostController::class, 'update']);

Route::post('/post', [PostController::class, 'store']);


// Rota para deletar um post
Route::delete('/{id}', [PostController::class, 'destroy']);

