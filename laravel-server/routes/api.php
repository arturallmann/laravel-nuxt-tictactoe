<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\MoveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Games Routes
route::post('/game', [GameController::class, 'createGame']);
route::get('/game', [GameController::class, 'index']);
route::patch('/game/{id}', [GameController::class, 'update']);
route::delete('/game/{id}', [GameController::class, 'destroy']);

//Move Routes
route::post('/move', [MoveController::class, 'createMove']);
route::get('/move', [MoveController::class, 'index']);
route::delete('/move/{id}', [MoveController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
