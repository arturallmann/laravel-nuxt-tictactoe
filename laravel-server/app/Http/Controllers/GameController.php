<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    //POST(/api/games)
    public function createGame(Request $request) {

        $validatedData = $request->validate([
            'player_x' => 'required|string',
            'player_o' => 'required|string',
            'game_state' => 'required|string',
            'winner' => 'nullable|string',
        ]);
        $game = new Game;
        $game->user_id = Auth::id();
        $game->save();

        return response()->json(['message' => 'Game added successfully', 'game_id' => $game->id], 201);

    }
    public function getUserGames()
    {
        $user = Auth::user();
        $games = $user->games;

        return response()->json($games);
    }
}
