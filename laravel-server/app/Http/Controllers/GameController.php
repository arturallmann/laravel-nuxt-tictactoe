<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //POST(/api/games)
    public function createGame(Request $request) {

        $game = new Game;

        $game->player_x = $request->input('player_x');
        $game->player_o = $request->input('player_o');
        $game->game_state = "in progress";
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
        $game->game_state = $request->input('game_state');
        $game->winner= $request->input('winner');

        return response()->json(['message'=> 'Game updated successfully'], 201);
    }
    //DELETE(/api/games/{id})
    public function destroy($id)
    {
        $game = Game::findOrFail($id);

        $game->delete();

        return response()->json(['message'=>'Game deleted successfully'], 201);
    }
}
