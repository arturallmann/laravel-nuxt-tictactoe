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
route::post('/games', [GameController::class, 'createGame']);
route::get('/games', [GameController::class, 'index']);
route::patch('/games/{id}', [GameController::class, 'update']);
route::delete('/games/{id}', [GameController::class, 'destroy']);

//Move Routes
route::post('/games/{id}/moves', [MoveController::class, 'createMove']);
Route::get('/games/{id}/moves', [MoveController::class, 'getMovesByGame']);
route::delete('/moves/{id}', [MoveController::class, 'deleteMove']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
