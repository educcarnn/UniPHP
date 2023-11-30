<?php

use App\Http\Controllers\PostController;
// Rotas para operações relacionadas a posts


    
    // Rota para listar todos os posts
    Route::get('/', [PostController::class, 'index']);

    // Rota para exibir um post específico
    Route::get('/{id}', [PostController::class, 'show']);

    // Rota para criar um novo post
    Route::post('/', [PostController::class, 'store']);

    // Rota para atualizar um post existente
    Route::patch('/{id}', [PostController::class, 'update']);

    // Rota para deletar um post
    Route::delete('/{id}', [PostController::class, 'destroy']);

