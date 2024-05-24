<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //POST(/api/games)
    public function createGame(Request $request) {

        $game = new Game;
        $game->player_x = $request->input('player_x');
        $game->player_o = $request->input('player_o');
        $game->in_progress = true;
        $game->created_at = Carbon::now();
        $game->save();

        return response()->json(['message' => 'Game added successfully'], 201);

    }
    //GET(/api/games)
    public function index() {
        $games = Game::all();

        return response()->json(['games' => $games], 200);
    }
    //PUT(/api/games/{id})
    public function update(Request $request, $id) {

        $game = Game::findOrFail($id);
        $data = $request->all();

        $game->update($data);
        $game->in_progress = $request->input('in_progress');
        $game->winner= $request->input('winner');

        return response()->json(['message'=> 'Game updated successfully'], 201);
    }
}
