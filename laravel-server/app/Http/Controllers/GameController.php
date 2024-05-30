<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function getUserGames(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        $games = Game::where('user_id', $userId)->get();

        return response()->json(['games' => $games], 200);
    }

    public function saveGame(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        $game = new Game();
        $game->user_id = $userId;
        $game->player_x = $request->input('player_x');
        $game->player_o = $request->input('player_o');
        $game->game_state = $request->input('game_state');
        $game->winner = $request->input('winner');
        $game->save();

        return response()->json(['message' => 'Game saved successfully'], 201);
    }
}
