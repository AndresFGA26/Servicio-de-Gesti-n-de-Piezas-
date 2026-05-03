<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ProjectController;
use App\Http\Controllers\V1\BlockController;
use App\Http\Controllers\V1\PieceController;

Route::prefix('v1')->middleware('auth.jwt')->group(function () {

    //Projects
    Route::apiResource('projects', ProjectController::class);

    //Blocks
    Route::get('projects/{project}/blocks', [BlockController::class, 'index']);
    Route::apiResource('blocks', BlockController::class)->except(['index']);

    //Pieces

    Route::get('blocks/{block}/pieces', [PieceController::class, 'index']);
    Route::post('blocks/{block}/pieces', [PieceController::class, 'store']);


    Route::apiResource('pieces', PieceController::class)->except(['index','store']);
    Route::get('reports/pieces', [PieceController::class, 'report']);

});


/*
 Este archivo
 Expone tu API REST
protege todo con JWT
 conecta controllers con endpoints
define relaciones (project → blocks → pieces)
 */
