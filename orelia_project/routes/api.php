<?php

use App\Http\Controllers\Api\PieceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pieces', [PieceApiController::class, 'index'])->name('api.pieces.index');
Route::get('/pieces/{id}', [PieceApiController::class, 'show'])->name('api.pieces.show');
